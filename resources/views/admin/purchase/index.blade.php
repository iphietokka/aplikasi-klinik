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
							 <div class="input-group margin">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Action
                                     <span class="fa fa-caret-down"></span></button>
                                            <ul class="dropdown-menu">
										<li><a class="dropdown-item" href="{{ route('purchase-edit',$transaction->id) }}"><i class="fa fa-edit"></i> Edit</a>
										</li>
										<li><a class="dropdown-item" href="{{route('purchase-show',$transaction->id) }}"><i class="fa fa-eye"></i> Details</a>
										</li>
										<li><a class="dropdown-item" href="{{url('purchase/invoice/'.$transaction->id) }}"><i class="fa fa-dollar"></i> Invoice</a>
										</li>
										<li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#status_modal{{$transaction->id}}"><i class="fa fa-check"></i> Recieved</a>
										</li>
										<li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_modal{{$transaction->id}}"><i class="fa fa-trash"></i> Delete</a>
										</li>
										 
									</div>
								</div>
							</td>
						</tr>

					{{-- Modal Delete Start --}}
                        <div class="modal fade" tabindex="-1" role="dialog" id="delete_modal{{$transaction->id}}">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        <div class="row">
                                            <h4 class="modal-heading">Are You Sure?</h4>
                                            <p>Do you really want to delete these records? This process cannot be undone.</p>
                                        </div>
                                    </div>
                            <div class="modal-footer">
                                <form class="form-horizontal" method="POST" action="{{ route('purchase-delete', $transaction->id) }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button type="reset" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                                </form>
                                 </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                         </div><!-- /.modal -->
                        {{-- Modal Delete END --}}

				 <div class="modal fade" tabindex="-1" role="dialog" id="status_modal{{$transaction->id}}">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                      <div class="row">
											<h4 class="modal-heading">Are you sure you want to change this purchase status?</h4>
											<p style="color: red;"> Note: Jika anda melakukan perubahan status. Aksi ini tidak dapat diulang</p>
										</div>
                                    </div>
                           	<div class="modal-footer">
										<form class="form-horizontal" method="POST" action="{{route('purchase-received', $transaction->id) }}" enctype="multipart/form-data">
											{{ csrf_field() }}

											<input name="_method" type="hidden" value="POST">
											<button type="reset" class="btn btn-info" data-dismiss="modal">Cancel</button>
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