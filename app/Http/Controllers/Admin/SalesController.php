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
        $data->description = $request->description;
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
                $detail->quantity = $request['quantity'][$key];
                $detail->sub_total = $request['sub_total'][$key];
                $detail->unit_cost_price = $request['unit_cost_price'][$key];
                $detail->save();
                $total = $total +  $detail->sub_total;
                $total_cost_price = $total_cost_price + ($detail->unit_cost_price *  $detail->quantity);
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
            return redirect($this->title)->with('success', 'Data saved successfully!');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
