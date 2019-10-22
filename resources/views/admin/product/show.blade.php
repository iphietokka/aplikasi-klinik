@extends('layouts.app')
@section('pageTitle', 'Detail Produk')
@section('content')
   <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
  
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Detail Product {{ $products->name }} </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
        <tr>
            <th>Code</th>
            <td>{{ $products->code }}</td>
        </tr>
        <tr>    
            <th>Name</th>
            <td>{{ $products->name }}</td>
        </tr>
        <tr>
            <th>Category</th>
            <td>{{ $products->category->name }}</td>
        </tr>
        <tr>
            <th>Cost Price</th>
            <td> {{$products->cost_price_format }}</td>
        </tr>
        <tr>
            <th>Sale Price</th>
            <td>{{ $products->sales_price_format }}</td>
        </tr>
        <tr>
            <th>Opening Stock</th>
            <td>{{ $products->initial_stock }}</td>
        </tr>
        <tr>
            <th>Total Stock</th>
            <td>{{ $products->total_stock }}</td>
        </tr>
        <tr>
            <th>Unit</th>
            <td>{{ $products->unit }}</td>
        </tr>
        <tr>
            <th>Details</th>
            <td>{{ $products->details }}</td>
        </tr>
     
    </thead>
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

   <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">History Pembelian {{ $products->name }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="text-center">No.</th>
                  <th class="text-center">Purchase Date</th>
                  <th class="text-center">Inovice No</th>
                  <th class="text-center">Price</th>
                  <th class="text-center">Quantity</th>
                  <th class="text-center">Supplier</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($data as $product)
                    <tr>
                    <td class="text-center">{{$loop->iteration}}</td>
                    <td class="text-center">{{ $product->purchase->purchase_date }}</td>
                    <td class="text-center">{{ $product->purchase->invoice_no }}</td>
                    <td class="text-center">{{ $product->purchase->total }}</td>
                    <td class="text-center">{{ $product->quantity }}</td>
                    <td class="text-center">{{ $product->purchase->supplier->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
  
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">History Penjualan {{ $products->name }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text-center">Sales Date</th>
                    <th class="text-center">Inovice No</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Customer</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($datas as $product)
                    <tr>
                    <td class="text-center">{{ $product->sales->sales_date }}</td>
                    <td class="text-center">{{ $product->sales->invoice_no }}</td>
                    <td class="text-center">{{ $product->sales->total_format }}</td>
                    <td class="text-center">{{ $product->quantity }}</td>
                    <td class="text-center">{{ $product->sales->customers->name }}</td>
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

   <!-- Main content -->
    
@endsection