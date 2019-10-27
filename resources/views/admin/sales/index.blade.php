@extends('layouts.app')
@section('content')
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Data Penjualan Product</h3>
					<a href="{{ route('sales-create') }}" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Tambah Data</a>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table id="example2" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Tanggal</th>
								<th class="text-center">Invoice</th>
								<th class="text-center">Total</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($sales as $sale)
							<tr>
							<td class="text-center">{{$loop->iteration}}</td>
								<td class="text-center">{{$sale->sales_date}}</td>
								<td class="text-center">{{$sale->invoice_no}}</td>
								<td class="text-center">{{$sale->total_format}}</td>
								<td class="text-center">
									<div class="input-group margin">
										<div class="input-group-btn">
											<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Action
												<span class="fa fa-caret-down"></span></button>
												<ul class="dropdown-menu"> 
													<li><a class="dropdown-item" href="{{route('sales-show',$sale->id) }}"><i class="fa fa-eye"></i> Details</a>
													</li>
													<li><a class="dropdown-item" href="{{route('sales-invoice',$sale->id) }}"><i class="fa fa-dollar"></i> Invoice</a>
													</li>
													<li><a class="dropdown-item" href="{{ route('sales-return', $sale->id) }}"><i class="fa fa-check"></i> Return</a>
													</li>
													<li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_modal{{$sale->id}}"><i class="fa fa-trash"></i> Delete</a>
													</li>

												</div>
											</div>
										</td>
									</tr>

									{{-- Modal Delete Start --}}
									<div class="modal fade" tabindex="-1" role="dialog" id="delete_modal{{$sale->id}}">
										<div class="modal-dialog modal-sm" role="document">
											<div class="modal-content">
												<div class="modal-body text-center">
													<div class="row">
														<h4 class="modal-heading">Are You Sure?</h4>
														<p>Do you really want to delete these records? This process cannot be undone.</p>
													</div>
												</div>
												<div class="modal-footer">
													<form class="form-horizontal" method="POST" action="{{ route('sales-delete', $sale->id) }}" enctype="multipart/form-data">
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