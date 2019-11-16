@extends('layouts.app')
@section('content')
<section class="invoice" id="printableArea">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> Aplikasi Klinik, Inc.
                <small class="pull-right">{{$date}}</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            From :
            <address>
                <strong>Admin, Inc.</strong><br>
                795 Folsom Ave, Suite 600<br>
                San Francisco, CA 94107<br>
                Phone: (804) 123-5432<br>
                Email: info@almasaeedstudio.com
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            To :
            <address>
                <strong>{{$data->customers->name}}</strong><br>
                {{$data->customers->address}}<br>
                Phone: {{$data->customers->phone}}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Invoice {{$data->invoice_no}}</b><br>
            <b>Order Date:</b> {{date('d F Y', strtotime($data->sales_date))}}<br>
            <b>Payment Status:</b> @if(isset($payments->payment_status))
            {{$payments->payment_status}}
            @else
            Unpaid
            @endif<br>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th style="width: 10%">Quantity</th>
                        <th style="width: 10%">Price</th>
                        <th style="width: 10%" class="text-right">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detail as $product)
                    <tr>
                        <td>1</td>
                        <td>{{$product->product->name}} </td>
                        <td>{{ $product->quantity}}</td>
                        <td>{{ $product->price_format }}</td>
                        <td class="text-right">Rp{{number_format($product->quantity*$product->price,2,',','.')}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
            <p class="lead">Notes:</p>
            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                All accounts are to be paid within 7 days from receipt of
                invoice. To be paid by cheque or credit card or direct payment
                online. If account is not paid within 7 days the credits details
                supplied as confirmation of work undertaken will be charged the
                agreed quoted fee noted above.
            </p>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
            <p class="lead">Date : {{date('d F Y', strtotime($data->sales_date))}}</p>

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">Paid:</th>
                        <td>{{$transaction->paid_format}}</td>
                    </tr>
                    <tr>
                        <th>Due</th>
                        <td>Rp{{number_format($due,2,',','.')}}</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td>{{$transaction->total_format}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-xs-12">
            <a href="" class="btn btn-danger" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
@endsection