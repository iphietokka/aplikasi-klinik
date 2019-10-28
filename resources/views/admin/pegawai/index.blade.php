@extends('layouts.app')
@section('pageTitle', 'Pegawai')
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Semua Pegawai</h3>
                    <a href="#" class="btn btn-info pull-right" data-toggle="modal" data-target="#tambah-data"><i class="fa fa-plus"></i> Tambah Pegawai</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Alamat</th>
                                <th class="text-center">Telepon</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($data as $dt)
                            <tr>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td class="text-center">{{$dt->name}}</td>
                                <td class="text-center">{{$dt->address}}</td>
                                <td class="text-center">{{$dt->phone}}</td>
                                <td class="text-center">{{$dt->units->name}}</td>
                                <td class="text-center">
                                    @if($dt->status == 'active')<span class="label label-info">Aktif</span>@endif
                                    @if($dt->status == 'non-active')<span class="label label-danger">Non-Aktif</span>@endif
                                
                                </td>
                                <td class="text-center">
                                    <div class="input-group margin">
                                        <div class="input-group-btn">
                                             <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Action
                                                <span class="fa fa-caret-down"></span></button>
                                                <ul class="dropdown-menu">
                                                <li>
                                                <a href="#" data-toggle="modal" data-target="#edit_modal{{$dt->id}}"> <i class="fa fa-edit"></i> Edit</a>
                                                </li>
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
                                            <form class="form-horizontal" method="POST" action="{{ route('pegawai-delete', $dt->id) }}" enctype="multipart/form-data">
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
                            <div class="modal fade" id="edit_modal{{$dt->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Edit Data Pegawai</h4>
                                            </div>
                                            <div class="modal-body">
                                                @if (count($errors) > 0)
                                                <div class="alert alert-default">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @endif

                                                <!-- form start -->
                                                <form method="POST" role="form" action="{{ route('pegawai-update', $dt->id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="box-body">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Name</label>
                                                            <input type="text" class="form-control" placeholder="Nama" name="name" value="{{$dt->name}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Address</label>
                                                            <textarea name="address" id="" cols="30" rows="3" class="form-control">{{$dt->address}}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Phone</label>
                                                            <input type="text" class="form-control" placeholder="Phone" name="phone" value="{{$dt->phone}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Unit</label>
                                                            <select name="unit_id" id="" class="form-control">
                                                            <option value="{{$dt->unit_id}}">{{$dt->units->name}}</option>
                                                            @foreach ($units as $key => $value)
                                                                <option value="{{$key}}">{{$value}}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Status :</label>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="gender" @if($dt->status == "active") checked @endif  value="active"> Aktif
                                                            </label>
                                                        </div>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="gender" @if($dt->status == "non-active") checked @endif  value="non-active"> Non-Aktif
                                                            </label>
                                                        </div>
                                                        </div>
                                                    </div>

                                                    {{-- end form --}}

                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="id" value="{{$dt->id}}">
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
                                {{-- MODAL EDIT END --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="modal fade" id="tambah-data">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Tambah Data Pegawai</h4>
                            </div>
                            <div class="modal-body">
                               
                                <form method="POST" role="form" action="{{ route('pegawai-store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Name</label>
                                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Nama" name="name" value="{{old('name')}}">
                                             @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Address</label>
                                            <textarea name="address" id="" cols="30" rows="3" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="Adress">{{old('address')}}</textarea>
                                            @if ($errors->has('address'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="Phone" name="phone" valu="{{old('phone')}}">
                                             @if ($errors->has('phone'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                         <div class="form-group">
                                            <label>Unit</label>
                                             <select name="unit_id" id="" class="form-control">
                                               @foreach ($units as $key => $value)
                                               <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                               </select>
                                             @if ($errors->has('unit_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('unit_id') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form=group">
                                             <label>Status</label>
                                            <div class="radio">
                                            <label>
                                                <input type="radio" name="status" value="active"> Aktif
                                            </label>
                                        </div>
                                         <div class="radio">
                                            <label>
                                                <input type="radio" name="status" value="non-active"> Non-Aktif
                                            </label>
                                        </div>
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
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content --> 
        @endsection
        @section('scripts')
        <script type="text/javascript">
            @if (count($errors) > 0)
            $('#tambah-data').modal('show');
            @endif
        </script>
        <script>
            $(function() {

                $("#example2").DataTable();

            });
        </script>
        @endsection