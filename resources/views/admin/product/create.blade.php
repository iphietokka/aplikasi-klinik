@extends('layouts.app')
@section('content')
 <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
     <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Product</h3>
            </div>
     <form role="form" method="POST" action="{{ route('product-store')}}" enctype="multipart/form-data">
                @csrf
            <div class="box-body">
              <div class="row">
                <div class="col-xs-4">
                  <label>Nama</label>
                  <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Nama Product" name="name" id="productName" value="{{old('name')}}">
                  @if ($errors->has('name'))
                   <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                    </span>
                     @endif
                </div>
                <div class="col-xs-4">
                    <label>Code</label>
                   <div class="input-group">
                  <div class="input-group-addon">
               <button type="button" onclick="document.getElementById('code').value = generateCode()" title="Click here to generate random code" ><i class="fa fa-random"></i> </button>
                  </div>
                <input type="text" class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" name="code" id="code" placeholder="Kode Produk" value="{{old('code')}}">
               
                </div>
                 @if ($errors->has('code'))
                   <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('code') }}</strong>
                    </span>
                     @endif
                </div>
                <div class="col-xs-4">
                    <label>Category</label>
                  <select name="category_id" id="" class="form-control select2">
                      @foreach ($categories as $key => $value)
                  <option value="{{$key}}">{{$value}}</option>
                      @endforeach
                  </select>
                </div>
              </div>
              <br>
                <div class="row">
                <div class="col-xs-4">
                  <label>Harga Beli</label>
                  <input type="text" class="form-control{{ $errors->has('cost_price') ? ' is-invalid' : '' }} " placeholder="Harga Beli" name="cost_price" value="{{old('cost_price')}}">
                @if ($errors->has('cost_price'))
                   <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('cost_price') }}</strong>
                    </span>
                     @endif
                </div>
                <div class="col-xs-4">
                    <label>Harga Jual</label>
                <input type="text" class="form-control{{ $errors->has('sales_price') ? ' is-invalid' : '' }}"  placeholder="Harga Jual" name="sales_price" value="{{old('sales_price')}}">
                 @if ($errors->has('sales_price'))
                   <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('sales_price') }}</strong>
                    </span>
                     @endif
                </div>
                <div class="col-xs-4">
                    <label>Stock</label>
                <input type="text" class="form-control{{ $errors->has('initial_stock') ? ' is-invalid' : ''}}" placeholder="Stock" name="initial_stock" value="{{old('intial_stock')}}">
                @if ($errors->has('initial_stock'))
                   <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('initial_stock') }}</strong>
                    </span>
                     @endif
            </div>
              </div>
               <br>
                <div class="row">
                <div class="col-xs-4">
                  <label>Unit</label>
                  <input type="text" class="form-control {{$errors->has('initial_stock') ? 'is-invalid' : ''}}" placeholder="Unit" name="unit" value="{{old('unit')}}">
                @if ($errors->has('unit'))
                   <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('unit') }}</strong>
                    </span>
                     @endif
                </div>
                <div class="col-xs-4">
                    <label>Detail</label>
                    <textarea name="details" id="" cols="30" rows="2" class="form-control" placeholder="Detail Produk"></textarea>
                </div>
              </div>
            </div>
             <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
      </div>
    </section>
@endsection
@section('scripts')
   <script>
   $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
     })
    </script> 
    
    <script type="text/javascript">
    /*generate random product code*/
    var productName = document.getElementById('productName');
    var randomNumber;
    productName.onkeyup = function(){
        randomNumber = productName.value.toUpperCase();
    }

    function generateCode() {
        if(randomNumber){
            return randomNumber.substring(0, 2) + (Math.floor(Math.random()*1000)+ 999);
        }else{
            return Math.floor(Math.random()*90000) + 100000;
        }   
    }
    /*ends*/

    $(function() {
        $('.number').on('input', function() {
            match = (/(\d{0,100})[^.]*((?:\.\d{0,5})?)/g).exec(this.value.replace(/[^\d.]/g, ''));
            this.value = match[1] + match[2];
        });
    });

     $(document).ready(function () {
        $('.selectPickerLive').selectpicker();
    })

</script>
@endsection