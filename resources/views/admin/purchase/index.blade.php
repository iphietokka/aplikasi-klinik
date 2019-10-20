@extends('layouts.app')
@section('content')
      <!-- Main content -->
    <section class="content">
      <div class="row">
          <div class="col-xs-12">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Pembelian Product</h3>
              <a href="{{ route('purchase-create') }}" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Tambah Data</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Invoice</th>
                  <th>Supplier</th>
                  <th>Total</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
             @foreach($transactions as $transaction)
               <tr>
							<td class="text-center">
								{{$transaction->purchase_date}}
							</td>
							<td class="text-center">
								{{$transaction->invoice_no}}
							</td>

							<td class="text-center"> {{$transaction->supplier->name}} </td>
							<td> {{$transaction->total_format}}</td>

							<td class="text-center">
						@if($transaction->status == 'received')<span style="color: blue;">Received</span>@endif
							@if($transaction->status == 'order')<span style="color: green;">Order</span>@endif
								
							</td>
							
							
							<td class="text-center">
								<div class="btn-group">
									<button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <i class="mdi mdi-chevron-down"></i> </button>
									<div class="dropdown-menu">
										
										<a class="dropdown-item" href="{{url('purchase/edit/'.$transaction->id) }}"><i class="fa fa-edit"></i> Edit</a>
										<a class="dropdown-item" href="{{url('purchase/details/'.$transaction->id) }}"><i class="fa fa-eye"></i> Details</a>
										<a class="dropdown-item" href="{{url('purchase/invoice/'.$transaction->id) }}"><i class="fa fa-file-invoice-dollar"></i> Invoice</a>
										<a class="dropdown-item" href="#" data-toggle="modal" data-target="#status_modal{{$transaction->id}}"><i class="fa fa-check"></i> Recieved</a>
										 <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_modal{{$transaction->id}}"><i class="fa fa-trash"></i> Delete</a>
										
									</div>
								</div>
							</td>
						</tr>

						<!--  MODAL DELETE DATA -->
						<div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;" id="delete_modal{{$transaction->id}}">
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="mySmallModalLabel">Delete Data</h4>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									</div>
									<div class="modal-body">
										<div class="row">
											<h4 class="modal-heading">Are you sure you want to delete this purchase?</h4>
											<p style="color: red;"> Note: If you delete this purchase, all the transactions of this purchase will also be deleted &amp; product will also adjusted.</p>
										</div>
									</div>
									<div class="modal-footer">
										<form class="form-horizontal" method="POST" action="{{url('purchase/'.$transaction->id) }}" enctype="multipart/form-data">
											{{ csrf_field() }}

											<input name="_method" type="hidden" value="DELETE">
											<button type="reset" class="btn btn-info">Cancel</button>
											<button type="submit" class="btn btn-danger">Delete</button>
										</div>
									</form>
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
					<!--  END MODAL DELETE DATA -->

					<div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;" id="status_modal{{$transaction->id}}">
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="mySmallModalLabel">Received Product</h4>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									</div>
									<div class="modal-body">
										<div class="row">
											<h4 class="modal-heading">Are you sure you want to change this purchase status?</h4>
											<p style="color: red;"> Note: If you delete this purchase, all the transactions of this purchase will also be deleted &amp; product will also adjusted.</p>
										</div>
									</div>
									<div class="modal-footer">
										<form class="form-horizontal" method="POST" action="{{url('purchase/received/'.$transaction->id) }}" enctype="multipart/form-data">
											{{ csrf_field() }}

											<input name="_method" type="hidden" value="POST">
											<button type="reset" class="btn btn-info">Cancel</button>
											<button type="submit" class="btn btn-danger">Change</button>
										</div>
									</form>
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
					<!--  END MODAL DELETE DATA -->
					@endforeach
				</tbody>
               
                </tbody>
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