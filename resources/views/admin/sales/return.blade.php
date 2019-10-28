@extends('layouts.app')
@section('content')
<section class="content">
      <div class="row">
          <div class="col-xs-12">
            <div class="box">
            <div class="box-header">
             @if($transaction->total - $transaction->paid <= 0)
			  <b> Payment of this sale is fully completed.</b> 
			    @else
				Payment of this sale is not completed. 
				</br>
				<b>Paid:</b> 
				{{$transaction->paid}} 
				</br>
				<b>Due:</b> 
				{{$transaction->net_total - $transaction->paid}}
			@endif
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped" style="background-color: #ddd;">
                <thead>
                <tr>
                    <th class="text-center">Product</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Return Qty</th>
                    <th class="text-center">Unit Price</th>
                </tr>
                </thead>
                <tbody>
            <form method="POST" action="{{route('sales-return', $data->id)}}" enctype="multipart/form-data">
			@csrf
             @foreach($detail as $sales)
                <tr>
                    <td class="text-center" width="30%">
                        <p>{{$sales->product->name}}</p>
                    </td>
                    <td class="text-center" width="30%">
                        <p>{{$sales->quantity}}</p>
                    </td>
                    <input type="hidden" name="sales_{{$sales->id}}" value="{{$sales->id}}">
                    <input type="hidden" name="transaction_id" value="{{$transaction->id}}">
                    <td width="15%" class="text-center">
                        <input type="text" name="quantity_{{$sales->id}}" class="form-control" value="0"  style="text-align:center;" onkeypress='return event.charCode <= 57 && event.charCode != 32 && event.charCode != 46' @if($sales->quantity == 0) disabled="true" @endif >
                    </td>
                    <td width="25%" class="text-center">
                        @if($sales->quantity != 0)
                            <p>
                                {{$sales->sub_total / $sales->quantity}} 
                            </p>
                            <input type="hidden" name="unit_price_{{$sales->id}}" value="{{$sales->sub_total / $sales->quantity}}">
                        @else
                            <p>
                                {{$sales->product->sale_price}}
                            </p>
                        @endif
                    </td>							
                </tr>
					@endforeach
				</tbody>
                <tfoot style="background-color: #fff;">	
					<td colspan="4">
						<input type="submit" class="btn btn-warning pull-right" value="Return">
					</td>
				</tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
    </div>
      <!-- /.row -->
</section>
@endsection
@section('scripts')
    <script>
$(function() {

$("#example2").DataTable();
});
</script>
@endsection