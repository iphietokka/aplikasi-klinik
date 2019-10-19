@extends('layouts.app')
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
                  <th>Rendering engine</th>
                  <th>Browser</th>
                  <th>Platform(s)</th>
                  <th>Engine version</th>
                  <th>CSS grade</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>Trident</td>
                  <td>Internet
                    Explorer 4.0
                  </td>
                  <td>Win 95+</td>
                  <td> 4</td>
                  <td>X</td>
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
      <!-- /.row -->
    </section>

   <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
  
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">History Penjualan {{ $products->name }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Rendering engine</th>
                  <th>Browser</th>
                  <th>Platform(s)</th>
                  <th>Engine version</th>
                  <th>CSS grade</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>Trident</td>
                  <td>Internet
                    Explorer 4.0
                  </td>
                  <td>Win 95+</td>
                  <td> 4</td>
                  <td>X</td>
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
      <!-- /.row -->
    </section>

@endsection