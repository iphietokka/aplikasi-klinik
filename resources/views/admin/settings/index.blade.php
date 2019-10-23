@extends('layouts.app')
@section('content')
<section class="content">
<div class="row" id="perusahaan">
<div class="col-xs-12">
<div class="box">
<!-- /.box-header -->
@foreach($data as $dt)
<div class="box-body">
<form method="POST" enctype="multipart/form-data" action="{{ route('settings-update', $dt->id) }}">
{{ csrf_field() }}
<div class="row">
<div class="col-sm-12">
<div class="form-group">
	<div class="row">
		<div class="col-sm-6">
			<label>Nama Perusahaan</label>
			<input type="hidden" name="id" value="{{$dt->id}}">
			<input class="form-control" name="company_name" placeholder="Nama Perusahaan"  value="{{$dt->company_name}}">

		</div>
		<div class="col-sm-6">
			<label>Phone</label>
			<input class="form-control" name="phone" placeholder="Phone"  value="{{$dt->phone}}">
		</div>
	</div>
</div>
<div class="form-group">
	<div class="row">
		<div class="col-sm-6">
			<label>Email</label>
			<input type="email" class="form-control" name="email" value="{{$dt->email}}">
        </div>
        <div class="col-sm-6">
			<label>Address</label>
			<input type="text" class="form-control" name="address" value="{{$dt->address}}">
		</div>
	</div>
</div>
</div>
<div class="col-sm-12">
<div class="form-group">
	<div class="row">
		<div class="col-sm-6">
			<label>Alert Quantity</label>
			<input type="text" class="form-control" name="alert_product" value="{{$dt->alert_product}}">
		</div>
	</div>
</div>
</div>
<div class="col-sm-12">
<button type="submit" class="btn btn-primary pull-right">Save changes</button>
</div>
</div>
</div>
@endforeach
<!-- /.box-body -->
</div>
<!-- /.box -->
</div>

</div>

</section>
@endsection
