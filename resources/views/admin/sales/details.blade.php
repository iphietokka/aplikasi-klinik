@extends('layouts.app')
@section('pageTitle', 'Detail Penjualan')
@section('content')
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    No INV : <b>{{$data->invoice_no}}</b><br/>
                    Date : <b> {{date('d F Y', strtotime($data->sales_date))}} </b><br/>
                    Customer : <b>{{$data->customers->name}}</b><br/>
                    Total : <b>Rp{{number_format($data->total, 0, ',','.')}}</b><br/>
                    Description : {{nl2br($data->description)}}<br/>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Product</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Unit Price</th>
                                <th class="text-center">Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detail as $product)
                            <tr>
                                <td class="text-center">{{$product->product->name}}</td>
                                <td class="text-center">{{ $product->quantity}}</td>
                                <td class="text-center">{{ $product->price }}</td>
                                <td class="text-center">Rp{{number_format($product->sub_total)}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="text-right" colspan="3" >
                                    <b>Total Quantity :</b>
                                </td>
                                <td class="text-center">{{$transaction->sales_detail->sum('quantity')}}</td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="3" >
                                    <b>
                                        Total :
                                    </b>
                                </td>
                                <td class="text-center">Rp{{$transaction->total}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                  @if($transaction->return == 1)
              
                This sales has return item 
                @if($transaction->returnSales->count() != 0)
                <h5 style="text-align: left;">
                    <b>Biller:</b> 
                    {{$transaction->returnSales->first()->user->name}}
                    <br>
                    <b>Date:</b> 
                    {{$transaction->returnSales->first()->created_at}}
                </h5>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Product</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Return Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction->returnSales as $return)
                    <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td class="text-center">{{$return->sales->product->name}}</td>
                        <td class="text-center">{{$return->return_units}}</td>
                        <td class="text-center">{{$return->sales->sub_total }}</td> 
                        <td class="text-center">{{$return->return_amount}}</td>
                    </tr>
                    @endforeach
                        </tbody>
                    </table>
                </div>
                     @endif
    </div>
    @endif
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
   
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Payment</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Payment History</a></li>
                    <li><a href="#tab_3" data-toggle="tab">Make Payment </a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <li> <strong>Net Total : Rp.{{number_format($transaction->net_total)}}</strong></li>
                        <li><strong>Total Paid : 
                            Rp.{{number_format($transaction->paid)}}</strong>
                            @if($transaction->return == 1)
                            <small>(This sales has return item)</small>
                            @endif
                        </strong></li>
                        @if($transaction->return == 1 || ($transaction->net_total - $transaction->paid) > 0 )
                        <li><strong>Payment Due :
                            @if($transaction->net_total - $transaction->paid > 0)
                            Due: {{$transaction->net_total - $transaction->paid}}
                            @else
                            <br>
                            Total Return:
                            Rp.{{number_format($transaction->payments->where('type', 'return')->sum('amount'))}}
                            @endif
                        </strong></li>
                        @endif
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Method</th>
                                        <th class="text-center">Note</th>
                                        <th class="text-center">Amount</th>
                                        <th class="tect-center">Payment Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                    <tr>
                                        <td class="text-center">{{$payment->date}}</td>
                                        <td class="text-center">{{$payment->method}}</td>
                                        <td class="text-center">{{$payment->note}}</td>
                                        <td class="text-center">{{$payment->amount_format}}</td>
                                        <td class="text-center">{{$payment->payment_status}}</td>
                                        <td class="text-center">
                                            <a target="_BLINK" href="" class="btn btn-border btn-alt border-orange btn-link font-orange btn-xs">
                                                <i class="fa fa-print"></i> 
                                                Print
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr style="background-color: #F8FCD4;" class="text-center">
                                        <td colspan="3" class="text-right">
                                            <b>Total :</b>
                                        </td>
                                        <td colspan="1"  class="text-center bold">
                                            Rp.{{number_format($payments->sum('amount'), 2, ',', '.')}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">
                        @if($transaction->net_total - $transaction->paid > 0)

                        <form method="POST" action="{{route('sales-payment',$transaction->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="col-xs-4">
                                        <label>Tanggal</label>
                                        <input type="text" class="form-control" name="date" placeholder="Date" id="datepicker">
                                    </div>
                                    <div class="col-xs-4">
                                        <label>Amount</label>
                                        <input type="text" class="form-control" name="amount" placeholder="Amount" id="amount" onkeyup="sum();">
                                    </div>
                                    <div class="col-xs-4">
                                        <label>Method</label>
                                        <select class="form-control select2" name="method" style="width: 100%">
                                            <option value="">Select</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Credit">Credit</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body">
                                <div class="form-group">
                                    <div class="col-xs-4">
                                        <label>Note</label>
                                        <textarea name="note" class="form-control"></textarea>
                                    </div>

                                </div>
                            </div>

                            <div class="box-footer">
                                <input type="hidden" name="sales_id" value="{{$transaction->sales_id}}">
                                <input type="hidden" name="invoice_no" value="{{$transaction->invoice_no}}">
                                <input type="hidden" name="invoice_payment" value="1">
                                <input type="hidden" name="type" value="credit">
                                <button type="submit" class="btn btn-info">Submit</button>
                            </div>

                        </form>
                        @else
                        <h1>No Due</h1>
                        @endif
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->
    
</div>
</section>

@endsection
@section('scripts')
<script>
    $(function () {
//Initialize Select2 Elements
$('.select2').select2()
$('#datepicker').datepicker({

    autoclose: true
})
})
    function sum() {
        var txtFirstNumberValue = document.getElementById('subTotal').value;
        var txtSecondNumberValue = document.getElementById('paidTotal').value;
        var result = parseInt(txtSecondNumberValue) - parseInt(txtFirstNumberValue);
        if (!isNaN(result)) {
            document.getElementById('payment_due').value = result;
        }
    }
</script> 
@endsection