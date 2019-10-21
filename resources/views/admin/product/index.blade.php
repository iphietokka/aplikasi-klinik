@extends('layouts.app')
@section('content')
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Product</h3>
                    <a href="{{ route('product-create') }}" class="btn btn-info pull-right margin"><i class="fa fa-plus"></i> Tambah Product</a>
                    <a href="#" class="btn btn-info pull-right margin" data-toggle="modal" data-target="#tambah-data"><i class="fa fa-upload"></i> Import Product</a>
                </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Code</th>
                        <th class="text-center">Harga <small>(beli)</small></th>
                        <th class="text-center">Harga <small>(jual)</small></th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $dt)
                    <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td class="text-center">{{$dt->name}}</td>
                        <td class="text-center">{{$dt->code}}</td>
                        <td class="text-center">{{$dt->cost_price_format}}</td>
                        <td class="text-center">{{$dt->sales_price_format}}</td>
                        <td class="text-center">
                            <div class="input-group margin">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Action
                                     <span class="fa fa-caret-down"></span></button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                <a href="{{ route('product-edit', $dt->id) }}"> <i class="fa fa-edit"></i> Edit</a>
                                                </li>
                                                <li>
                                                <a href="{{ route('product-show', $dt->id) }}"> <i class="fa fa-eye"></i> Details</a>
                                                </li>
                                                <li>
                                                <a href="#" data-toggle="modal" data-target="#update_price{{$dt->id}}"> <i class="fa fa-dollar"></i> Update Price</a>
                                                </li>
                                                <li> <a data-toggle="modal" data-target="#check-data{{$dt->id}}" href="#"><i class="fa fa-check"></i> Stock Correction</a></li>
                                                <li><a href="" data-toggle="modal" data-target="#delete_modal{{$dt->id}}"><i class="fa fa-trash"></i> Hapus</a>
                                                </li>
                                            </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                        {{-- Modal Delete Start --}}
                        <div class="modal fade" tabindex="-1" role="dialog" id="delete_modal{{$dt->id}}">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        <div class="row">
                                            <h4 class="modal-heading">Are You Sure?</h4>
                                            <p>Do you really want to delete these records? This process cannot be undone.</p>
                                        </div>
                                    </div>
                            <div class="modal-footer">
                                <form class="form-horizontal" method="POST" action="{{ route('product-delete', $dt->id) }}" enctype="multipart/form-data">
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

                        {{-- Modal EDIT Start --}}
                        <div class="modal fade" id="update_price{{$dt->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Update Harga Produk</h4>
                                    </div>
                            <div class="modal-body">
                                <!-- form start -->
                         <form method="POST" role="form" action="{{ route('product-update-price', $dt->id) }}" enctype="multipart/form-data">
                                @csrf
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Update Harga Beli</label>
                                            <input type="text" class="form-control" placeholder="Harga Beli" name="cost_price" value="{{$dt->cost_price}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Update Harga Jual</label>
                                            <input type="text" class="form-control" placeholder="Harga Jual" name="sales_price" value="{{$dt->sales_price}}">
                                        </div>
                                    </div>
                            {{-- end form --}}
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="product_id" value="{{$dt->id}}">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                        </div>
                        <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                         {{-- Modal EDIT Start --}}
                        <div class="modal fade" id="check-data{{$dt->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Koreksi Stok</h4>
                                    </div>
                            <div class="modal-body">
                                <!-- form start -->
                         <form method="POST" role="form" action="{{ route('product-stock-correction', $dt->id) }}" enctype="multipart/form-data">
                                @csrf
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="hidden" name="product_id" value="{{$dt->id}}">
                                                    <input readonly type="text" name="name" value="{{$dt->name}}" class="form-control" placeholder="Nama Barang" required>
                                        </div>
                                         <div class="form-group">
                                            <label>Quantity</label>
                                             <input type="text" name="quantity" class="form-control">
                                        </div>
                                    </div>
                            {{-- end form --}}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                        </div>
                        <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        @endforeach

                    </tbody>
                </table>
             </div>
        <!-- /.box-body -->
            </div>
        <!-- /.box -->
              {{-- Modal EDIT Start --}}
                        <div class="modal fade" id="tambah-data">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Import Product</h4>
                                    </div>
                            <div class="modal-body">
                                <!-- form start -->
                         <form method="POST" role="form" action="{{ route('product-import') }}" enctype="multipart/form-data">
                                @csrf
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Upload File</label>
                                             <input type="file" name="file" class="form-control" required>
                                        </div>
                                    </div>
                            {{-- end form --}}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                        </div>
                        <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
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
