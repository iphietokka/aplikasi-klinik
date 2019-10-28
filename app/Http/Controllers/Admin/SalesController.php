<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Model\Sales;
use App\Model\SalesDetail;
use App\Model\Member;
use App\Model\Product;
use App\Model\Stock;
use App\Model\Transaction;
use App\Model\Payment;
use App\Model\Setting;

class SalesController extends Controller
{
    function __construct()
    {
        $this->title = "sales";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title;

        $sales = Sales::with('sales', 'customers')->where('active', '!=', 0)->orderBy('id', 'desc')->get();

        return view('admin.' . $title . '.index', compact('title', 'sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $members = Member::pluck('name', 'id');
        $products = Product::orderBy('name', 'asc')->get();
        $ym = Carbon::now()->format('Y/m');
        $row = Sales::withTrashed()->get()->count() > 0 ? Sales::withTrashed()->get()->count() + 1 : 1;
        $no_invoice = $ym . '/INV-' . Helper::ref($row);

        return view('admin.' . $title . '.create', compact('title', 'products', 'no_invoice', 'members'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Sales();
        $data->sales_date = date('Y-m-d', strtotime($request->sales_date));
        $ym = Carbon::now()->format('Y/m');
        $row = Sales::withTrashed()->get()->count() > 0 ? Sales::withTrashed()->get()->count() + 1 : 1;
        $no_invoice = $ym . '/INV-' . Helper::ref($row);
        $data->invoice_no = $no_invoice;
        $data->customer_id = $request->customer_id;
        $data->user_id = Auth::user()->id;
        $data->active = 1;
        $total_cost_price = 0;
        $total = 0;
        $paid = floatval($request->get('paid')) ?: 0;

        if ($data->save()) {
            $sales_id = $data->id;
            foreach ($request['product_id'] as $key => $product_id) :
                $detail = new SalesDetail();
                $detail->sales_id = $sales_id;
                $detail->product_id = $product_id;
                $detail->sub_total = $request['sub_total'][$key];
                $detail->quantity = $request['quantity'][$key];
                $detail->price = $request['price'][$key];
                $detail->save();
                $total = $total +  $detail->sub_total;
                $total_cost_price = $total_cost_price + ($detail->price *  $detail->quantity);
            endforeach;

            $data = Sales::find($sales_id);
            $data->total = $total;
            $data->save();

            $datas = Sales::find($sales_id);
            $data = SalesDetail::where('sales_id', '=', $sales_id)->orderBy('id', 'ASC')->get();
            foreach ($data as $data) :
                $detail = new Stock();
                $detail->product_id = $data->product_id;
                $detail->quantity = $data->quantity * -1;
                $detail->description = $datas->invoice_no;
                $detail->type = "sales";
                $detail->save();

                //Update Total Stock
                $detail = Product::find($data->product_id);
                $detail->total_stock = $detail->total_stock - $data->quantity;
                $detail->save();
                $total_payable = $total;
            endforeach;

            $transaction = new Transaction;
            $transaction->invoice_no = $no_invoice;
            $transaction->sales_id = $sales_id;
            $transaction->transaction_type = 'sales';
            $transaction->total_cost_price = $total_cost_price;
            $transaction->total = $total_payable;
            $transaction->net_total = $total_payable;
            $transaction->date = Carbon::parse($request->get('date'))->format('Y-m-d H:i:s');
            $transaction->paid = $paid;
            $transaction->save();

            if ($paid > 0) {
                $payment = new Payment;
                $payment->sales_id =  $sales_id;
                $payment->amount = $paid;
                $payment->method = $request->get('method');
                $payment->invoice_no = $no_invoice;
                $payment->payment_status = "paid";
                $payment->note = "Paid for Invoice " . $no_invoice;
                $payment->date = Carbon::parse($request->get('date'))->format('Y-m-d H:i:s');
                $payment->save();
            }
            return redirect('admin/' . $this->title)->with('success', 'Data saved successfully!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = $this->title;
        $data = Sales::with('user_modify', 'customers')->where('active', '!=', 0)->find($id);
        if ($data->count() > 0) {
            $detail = SalesDetail::with('product')->where('sales_id', '=', $id)
                ->orderBy('id', 'desc')
                ->get();

            $transaction = Transaction::with('payments')
                ->where('sales_id', '=', $id)
                ->first();

            $payments = Payment::with('transaction')
                ->where('sales_id', '=', $id)
                ->orderBy('date', 'desc')
                ->get();

            $total_paid = $transaction->payments()->where('type', 'credit')->sum('amount');
            $total_return = $transaction->payments()->where('type', 'return')->sum('amount');
            $total = $total_paid -  $total_return;
            return view('admin.' . $title . '.details', compact('title', 'data', 'detail', 'transaction', 'payments', 'total'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function payment(Request $request, $id)
    {

        if ($request->get('invoice_payment') == 1) {
            //direct invoice-wise payment starts

            $ref_no = $request->get('invoice_no');
            $transaction = Transaction::where('invoice_no', $ref_no)->first();
            $previously_paid = $transaction->paid;
            $transaction->paid = round(($previously_paid + $request->get('amount')), 2);
            $transaction->save();

            //saving paid amount into payment table
            $payment = new Payment;
            $payment->sales_id = $request->get('sales_id');
            $payment->amount = round($request->get('amount'), 2);
            $payment->method = $request->get('method');
            $payment->type = $request->get('type');

            if ($request->get('invoice_no')) {
                $payment->invoice_no = $request->get('invoice_no');
            }
            $payment->payment_status = "paid";
            $payment->note = $request->get('note');
            $payment->date = Carbon::parse($request->get('date'))->format('Y-m-d H:i:s');
            $payment->save();
        } else {
            //customer-wise payment starts
            $amount = round($request->get('amount'), 2);
            $sell_id = $request->get('sales_id');
            $purchase = Sales::find($id);

            foreach ($purchase->transaction as $transaction) {
                $due = round(($transaction->transaction->total - $transaction->transaction->paid), 2);
                $previously_paid = $transaction->transaction->paid;
                if ($due >= 0 && $amount > 0) {
                    if ($amount > $due) {
                        $restAmount = $amount - $due;
                        $transaction->transaction->paid = $due + $previously_paid;
                        $transaction->save();
                        //payment
                        $payment = new Payment;
                        $payment->sales_id = $sell_id;
                        $payment->amount = $due;
                        $payment->method = $request->get('method');
                        $payment->invoice_no = $transaction->invoice_no;
                        $payment->note = $request->get('note');
                        $payment->type = $request->get('type');
                        $payment->payment_status = "unpaid";
                        $payment->date = Carbon::parse($request->get('date'))->format('Y-m-d H:i:s');
                        $payment->save();
                    } else {
                        $restAmount = 0;
                        $transaction->transact->paid = $amount + $previously_paid;
                        $transaction->save();

                        //payment
                        $payment = new Payment;
                        $payment->sales_id = $sell_id;
                        $payment->amount = $amount;
                        $payment->method = $request->get('method');
                        $payment->invoice_no = $transaction->invoice_no;
                        $payment->payment_status = "paid";
                        $payment->type = $request->get('type');
                        $payment->note = $request->get('note');
                        $payment->date = Carbon::parse($request->get('date'))->format('Y-m-d H:i:s');
                        $payment->save();
                    }

                    $amount = $restAmount;
                }
                if ($amount <= 0) {
                    break;
                }
            }
            //payment ends
        }
        return redirect($this->title)->with('success', 'Payment Success!');
    }

    public function invoice($id)
    {
        $title = $this->title;
        $data = Sales::with('user_modify', 'customers')->where('active', '!=', 0)->find($id);
        if ($data->count() > 0) {
            $detail = SalesDetail::with('product')->where('sales_id', '=', $id)
                ->orderBy('id', 'desc')
                ->get();

            $total_quantity = 0;
            foreach ($detail as $sell) {
                $total_quantity += $sell->quantity;
            }

            $transaction = Transaction::with('payments')
                ->where('sales_id', '=', $id)
                ->first();

            $due = abs($transaction->net_total - $transaction->paid);

            $payments = Payment::with('transaction')
                ->where('sales_id', '=', $id)
                ->first();

            $companies = Setting::orderBy('company_name', 'desc')
                ->get();

            return view('admin.' . $title . '.invoice', compact('title', 'data', 'detail', 'transaction', 'payments', 'total_quantity', 'companies', 'due'));
        }
    }

    public function return($id)
    {
        $title = $this->title;
        $data = Sales::with('user_modify', 'customers')->where('active', '!=', 0)->find($id);
        if ($data->count() > 0) {
            $detail = SalesDetail::with('product')->where('sales_id', '=', $id)
                ->orderBy('id', 'desc')
                ->get();

            $transaction = Transaction::with('payments')
                ->where('sales_id', '=', $id)
                ->first();

            $payments = Payment::with('transaction')
                ->where('sales_id', '=', $id)
                ->orderBy('date', 'desc')
                ->get();

            return view('admin.' . $title . '.return', compact('title', 'data', 'detail', 'transaction', 'payments'));
        }
    }

    public function returns(Request $request, $id)
    {
        $data = Sell::with('user_modify', 'customers')->where('active', '!=', 0)->find($id);
        if ($data->count() > 0) {
            $detail = SalesDetail::with('product')->where('sales_id', '=', $id)
                ->orderBy('id', 'desc')
                ->get();

            $transaction = Transaction::with('payments')
                ->where('sales_id', '=', $id)
                ->first();

            $payments = PaymentSell::with('transaction')
                ->where('sales_id', '=', $id)
                ->orderBy('date', 'desc')
                ->get();

            $previousTotal = $transaction->total;

            $total = 0;
            $updatedCostPrice = 0;
            $total_return_quantity = 0;


            foreach ($detail as $sell) {

                $returnQuantity = $request->get('quantity_' . $sell->id) ?: 0;
                $total_return_quantity += $returnQuantity;
                if ($returnQuantity === 0) {
                    $total =  $total + $sell->sub_total;
                    continue;
                }
                $returnUnitPrice = floatval($request->get('unit_price_' . $sell->id));

                $sellId = $request->get('sell_' . $sell->id);

                $sell = SellDetail::find($sellId);

                if ($returnQuantity > $sell->quantity) {
                    $warning = "Return Quantity (" . $returnQuantity . ") Can't be greater than the Selling Quantity (" . $sell->quantity . ")";
                    return redirect()->back()->withWarning($warning);
                }

                $updatedSellQuantity = $sell->quantity - $returnQuantity;
                $subTotal = $updatedSellQuantity * $returnUnitPrice;

                $sell->quantity = $updatedSellQuantity;
                $sell->sub_total = $subTotal;
                $sell->save();

                //update the cost price to deduct from transaction table
                $updatedCostPrice += $returnQuantity * $sell->unit_cost_price;

                $product = Product::find($sell->product_id);
                $currentStock = $product->total_stock;
                $product->total_stock = $currentStock + $returnQuantity;
                $product->save();

                $total += $subTotal;

                // Save Return statement
                $return = new ReturnTransaction;
                $return->sales_id = $sell->id;
                $return->invoice_no = $data->invoice_no;
                $return->return_units = $returnQuantity;
                $return->return_amount = ($returnQuantity * $returnUnitPrice);
                $return->returned_by = \Auth::user()->id;
                $return->save();

                $transaction = Transaction::find($sell->sales_id);
                $transaction->total = $total;
                $transaction->net_total = $total;
                $transaction->total_cost_price = $transaction->total_cost_price - $updatedCostPrice;
                $transaction->return = true;
                $transaction->save();

                $diff =  $return->sum('return_amount');

                //if difference is greater than due amount then we need to return some money to the customer

                $payment = new Payment;
                $payment->sales_id =  $sellId;
                $payment->amount =  $diff;
                $payment->method = 'cash';
                $payment->type = "return";
                $payment->invoice_no = $transaction->invoice_no;
                $payment->note = "Return for " . $transaction->invoice_no;
                $payment->date = Carbon::now()->format('Y-m-d H:i:s');
                $payment->save();
            }

            //update transaction for this return


            // $stock = new Stock;
            // $stock->product_id =  $sell->product_id;
            // $stock->description =  $diff;
            // $stock->quantity =  $return->return_units;
            // $stock->type = "correction";
            // $stock->save();

            return redirect($this->title)->with('success', 'Return Success!');
        }
    }
}
