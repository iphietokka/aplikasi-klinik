<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use App\Model\Product;
use App\Model\Purchase;
use App\Model\PurchaseDetail;
use App\Model\Supplier;
use App\Model\Transaction;
use App\Model\Payment;
use App\Model\Stock;
use Auth;
use DB;


class PurchaseController extends Controller
{
    function __construct()
    {
        $this->title = "purchase";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title;
        $transactions = Purchase::with('purchase', 'product', 'supplier', 'transactions')
            ->where('active', '!=', 0)
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.' . $title . '.index', compact('title', 'transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $suppliers = Supplier::pluck('name', 'id');
        $products = Product::orderBy('name', 'asc')->get();
        $ym = Carbon::now()->format('Y/m');
        $row = Purchase::withTrashed()->get()->count() > 0 ? Purchase::withTrashed()->get()->count() + 1 : 1;
        $no_invoice = $ym . '/INV-' . Helper::ref($row);
        return view('admin.' . $title . '.create', compact('title', 'suppliers', 'products', 'no_invoice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Purchase();
        $data->purchase_date = date('Y-m-d', strtotime($request->purchase_date));
        $ym = Carbon::now()->format('Y/m');
        $row = Purchase::withTrashed()->get()->count() > 0 ? Purchase::withTrashed()->get()->count() + 1 : 1;
        $no_invoice = $ym . '/INV-' . Helper::ref($row);
        $data->invoice_no = $no_invoice;
        $data->supplier_id = $request->supplier_id;
        $data->status = "order";
        $data->active = 1;
        $data->user_id = Auth::user()->id;
        $total = 0;
        $paid = floatval($request->get('paid')) ?: 0;
        if ($data->save()) {
            $id_purchase = $data->id;
            foreach ($request['product_id'] as $key => $product_id) :
                $detail = new PurchaseDetail();
                $detail->purchase_id = $id_purchase;
                $detail->product_id = $product_id;
                $detail->quantity = $request['quantity'][$key];
                $detail->price = $request['price'][$key];
                $total = $total + ($detail->price * $detail->quantity);
                $detail->save();
            endforeach;
            $data = Purchase::find($id_purchase);
            $data->total = $total;
            $data->save();

            $transaction = new Transaction;
            $transaction->invoice_no = $no_invoice;
            $transaction->purchase_id = $id_purchase;
            $transaction->transaction_type = 'purchase';
            $transaction->total =  $data->total;
            $transaction->net_total =  $data->total;
            $transaction->date = Carbon::parse($request->get('date'))->format('Y-m-d H:i:s');
            $transaction->paid = $paid;
            $transaction->save();

            if ($paid > 0) {
                $payment = new Payment;
                $payment->purchase_id = $id_purchase;
                $payment->amount = $request->get('paid');
                $payment->method = $request->get('method');
                $payment->invoice_no = $no_invoice;
                $payment->payment_status = "paid";
                $payment->note = "Paid for bill " . $no_invoice;
                $payment->date = Carbon::parse($request->get('date'))->format('Y-m-d H:i:s');
                $payment->save();
            }

            return redirect('admin/' . $this->title)->with('success', 'New Purchase Added!');
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
        $data = Purchase::with('user_modify', 'supplier')->where('active', '!=', 0)->find($id);
        if ($data->count() > 0) {
            $detail = PurchaseDetail::with('product')->where('purchase_id', '=', $id)
                ->orderBy('id', 'desc')
                ->get();
            $transaction = Transaction::with('payments')
                ->where('purchase_id', '=', $id)
                ->first();
            $payments = Payment::with('transaction')
                ->where('purchase_id', '=', $id)
                ->orderBy('date', 'desc')
                ->get();
            return view('admin.' . $title . '.details', compact('title', 'data', 'detail', 'transaction', 'payments'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = $this->title;
        $suppliers = Supplier::pluck('name', 'id');
        $ym = Carbon::now()->format('Y/m');
        $row = Purchase::withTrashed()->get()->count() > 0 ? Purchase::withTrashed()->get()->count() + 1 : 1;
        $no_invoice = $ym . '/INV-' . Helper::ref($row);
        $data = Purchase::with('supplier')->where('active', '!=', 0)->find($id);
        if ($data->count() > 0) {
            $detail = PurchaseDetail::with('product')->where('purchase_id', '=', $data->id)
                ->orderBy('id', 'ASC')
                ->get();
            return view('admin.' . $title . '.edit', compact('title', 'data', 'detail', 'no_invoice', 'suppliers'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Purchase::find($id);
        $data->purchase_date = date('Y-m-d', strtotime($request->purchase_date));
        $data->invoice_no = $request->invoice_no;
        $data->supplier_id = $request->supplier_id;
        $data->user_id = Auth::user()->id;
        $total = 0;
        if ($data->save()) {
            $delete = PurchaseDetail::where('purchase_id', '=', $id)->delete();
            foreach ($request['product_id'] as $key => $product_id) :
                $detail = new PurchaseDetail();
                $detail->purchase_id = $id;
                $detail->product_id = $product_id;
                $detail->quantity = $request['quantity'][$key];
                $detail->price = $request['price'][$key];
                $total = $total + ($detail->quantity * $detail->price);
                $detail->save();
            endforeach;
        }
        $data = Purchase::find($id);
        $data->total = $total;
        $data->save();
        return redirect('admin/' . $this->title)->with('success', 'Purchase Updated!');
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

    public function search(Request $request)
    {
        $return_arr = array();
        $data = array();
        $data['status_no'] = 0;
        $data['message']   = 'No Item Found!';
        $data['items'] = array();
        $item = DB::table('products')->where('name', 'LIKE', '%' . $request->search . '%')
            ->get();
        if ($item) {
            $data['status_no'] = 1;
            $data['message']   = 'Item Found';
            $i = 0;
            foreach ($item as $key => $value) {
                $return_arr[$i]['id'] = $value->id;
                $return_arr[$i]['name'] = $value->name;
                $return_arr[$i]['code'] = $value->code;
                $return_arr[$i]['category_id'] = $value->category_id;
                $return_arr[$i]['details'] = $value->details;
                $return_arr[$i]['cost_price'] = $value->cost_price;
                $return_arr[$i]['sales_price'] = $value->sales_price;
                $return_arr[$i]['initial_stock'] = $value->initial_stock;
                $return_arr[$i]['total_stock'] = $value->total_stock;
                $return_arr[$i]['unit'] = $value->unit;
                $return_arr[$i]['user_id'] = $value->user_id;
                $i++;
            }
            $data['items'] = $return_arr;
        }
        echo json_encode($data);
        exit;
    }

    public function received(Request $request, $id)
    {
        $purchase = Purchase::find($id);
        $data = PurchaseDetail::where('product_id', '=', $id)->orderBy('id', 'ASC')->get();
        foreach ($data as $data) :
            $details = new Stock();
            $details->product_id = $data->product_id;
            $details->quantity = $data->quantity;
            $details->description = $purchase->invoice_no;
            $details->type = "purchase";
            $details->save();

            $detail = Product::find($data->product_id);
            $detail->cost_price = $data->price;
            $detail->total_stock = $detail->total_stock + $data->quantity;
            $detail->save();
        endforeach;
        $data = Purchase::find($id);
        $data->status = "received";
        $data->user_id = Auth::user()->id;
        if ($data->save()) {
            return redirect('admin/' . $this->title)->with('success', 'Ubah Status Berhasil');
        } else {
            return redirect('admin/' . $this->title)->with('error', 'Terjadi Kesalahan');
        }
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
            $payment->purchase_id = $request->get('purchase_id');
            $payment->amount = round($request->get('amount'), 2);
            $payment->method = $request->get('method');
            if ($request->get('invoice_no')) {
                $payment->invoice_no = $request->get('invoice_no');
            }
            $payment->payment_status = "paid";
            $payment->note = $request->get('note');
            $payment->date = Carbon::parse($request->get('date'))->format('Y-m-d H:i:s');
            $payment->save();
        } else {
            //client-wise payment starts
            $amount = round($request->get('amount'), 2);
            $purchase_id = $request->get('purchase_id');
            $purchase = Purchase::find($id);

            foreach ($purchase->transactions as $transaction) {
                $due = round(($transaction->transactions->total - $transaction->transactions->paid), 2);
                $previously_paid = $transaction->transactions->paid;
                if ($due >= 0 && $amount > 0) {
                    if ($amount > $due) {
                        $restAmount = $amount - $due;
                        $transaction->transactions->paid = $due + $previously_paid;
                        $transaction->save();
                        //payment
                        $payment = new Payment;
                        $payment->purchase_id = $purchase_id;
                        $payment->amount = $due;
                        $payment->method = $request->get('method');
                        $payment->invoice_no = $transaction->invoice_no;
                        $payment->note = $request->get('note');
                        $payment->payment_status = "unpaid";
                        $payment->date = Carbon::parse($request->get('date'))->format('Y-m-d H:i:s');
                        $payment->save();
                    } else {
                        $restAmount = 0;
                        $transaction->transactions->paid = $amount + $previously_paid;
                        $transaction->save();

                        //payment
                        $payment = new Payment;
                        $payment->purchase_id = $purchase_id;
                        $payment->amount = $amount;
                        $payment->method = $request->get('method');
                        $payment->invoice_no = $transaction->invoice_no;
                        $payment->payment_status = "paid";
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
            //client-wise payment ends

        }


        $message = trans('core.payment_received');
        return redirect()->back()->withSuccess($message);
    }
}
