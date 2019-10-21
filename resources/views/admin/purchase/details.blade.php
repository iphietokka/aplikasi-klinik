@extends('layouts.app')
@section('content')
<section class="content">
      <div class="row">
        <div class="col-xs-12">
             <div class="box">
            <div class="box-header">
             No INV : <b>{{$data->invoice_no}}</b><br/>
                Date : <b> {{date('d F Y', strtotime($data->purchase_date))}} </b><br/>
                Supplier : <b>{{$data->supplier->name}}</b><br/>
                Total : <b>Rp{{number_format($data->total, 0, ',','.')}}</b><br/>
                Status : @if($data->status == 'received')<span style="color: blue;">Received</span>@endif
                @if($data->status == 'order')<span style="color: green;">Order</span>@endif<br/>
                Description : {{nl2br($data->description)}}<br/>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Sub Total</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($detail as $product)
                    <tr>
                    <td>{{$product->product->name}}</td>
                    <td>{{ $product->quantity}}</td>
                    <td>{{ $product->price_format }}</td>
                    <td>Rp{{number_format($product->quantity*$product->price,2,',','.')}}</td>
                    </tr>
                    @endforeach
              
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
            </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
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
                <li><strong>Total Paid : Rp.{{number_format($transaction->paid)}}</strong></li>
                <li><strong>Payment Due : Rp.{{number_format($transaction->net_total - $transaction->paid)}}</strong></li>
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
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                    <td class="text-center">{{$payment->date}}</td>
                    <td class="text-center">{{$payment->method}}</td>
                    <td class="text-center">{{$payment->note}}</td>
                    <td class="text-center">{{$payment->amount}}</td>
                    <td class="text-center">
                    <a target="_BLANK" href="{{url('purchase/receipt/'.$payment->id) }}" class="btn btn-border btn-alt border-orange btn-link font-orange btn-xs">
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
          {{$payments->sum('amount')}}
        </td>
      </tr>
                </tbody>
              </table>
            </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                @if($transaction->net_total - $transaction->paid > 0)

                <form method="POST" action="{{route('purchase-payment',$transaction->id) }}" enctype="multipart/form-data">
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
                <input type="hidden" name="purchase_id" value="{{$transaction->purchase_id}}">
                <input type="hidden" name="invoice_no" value="{{$transaction->invoice_no}}">
                <input type="hidden" name="invoice_payment" value="1">
                <button type="submit" class="btn btn-info">Submit</button>
              </div>

                </form>
        @else
        <h1>No Due</h1>
        @endif
                                    {{-- end form --}}
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->
 </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
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