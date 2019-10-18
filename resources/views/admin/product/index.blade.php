@extends('layouts.app')
@section('content')
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
                <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Product</h3>
              <a href="{{ route('product-create') }}" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Tambah Product</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama</th>
                  <th>Code</th>
                  <th>Harga <small>(beli)</small></th>
                  <th>Harga <small>(jual)</small></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>Trident</td>
                  <td>Internet</td>
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
@section('scripts')
     <script>
            $(function() {

                $("#example2").DataTable();
            });
        </script>
@endsection
