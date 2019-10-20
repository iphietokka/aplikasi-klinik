@extends('layouts.app')
@section('content')
 <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
     <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah Data Pembelian</h3>
            </div>
     <form role="form" method="POST" action="{{ route('purchase-store')}}" enctype="multipart/form-data">
                @csrf
            <div class="box-body">
              <div class="row">
                <div class="col-xs-4">
                  <label>Tanggal</label>
                  <input type="text" class="form-control" placeholder="Tanggal Pembelian" name="purchase_date" value="{{old('purchase_date')}}" id="datepicker">
                  @if ($errors->has('purchase_date'))
                   <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('purchase_date') }}</strong>
                    </span>
                     @endif
                </div>
                <div class="col-xs-4">
                    <label>Invoice No.</label>
                <input type="text" class="form-control auto{{ $errors->has('invoice_no') ? ' is-invalid' : '' }}" name="invoice_no"  placeholder="Nomor Invoice" value="{{$no_invoice}}" id="invoice_no">
                <input type="hidden" name="invoice_no" value="{{$no_invoice}}">
                </div>
                <div class="col-xs-4">
                    <label>Supplier</label>
               <select name="supplier_id" class="form-control select2">
                   @foreach ($suppliers as $key => $value)
               <option value="{{$key}}">{{$value}}</option>
                   @endforeach
               </select>
                </div>
                </div>
                <br>
                 <div class="row">
                <div class="col-xs-4">
                  <label>Nama/Kode</label>
                  <input class="form-control auto" placeholder="Search Item" id="search" >
                </div>
                </div>
                <br>
                <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="purchaseInvoice" class="table table-bordered table-hover">
                <tbody>
                <tr class="dynamicRows">
                    <th class="text-center">Name</th>
                    <th class="text-center">Unit Cost</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Sub Total</th>
                    <th class="text-center">Action</th>
                </tr>
                <tr class="tableInfo">
					<td colspan="4" align="right"><strong>Total</strong></td>
					<td align="left" colspan="2"><input type="text" class="form-control subTotal" id="subTotal" onkeyup="sum();" readonly></td>
                </tr>
                <tr class="tableInfo"><td colspan="4" align="right"><strong>Paid</strong></td><td align="left" colspan="2"><input type='text'  class="form-control" id = "paidTotal" name="paid" onkeyup="sum();"></td></tr>
                <tr class="tableInfo"><td colspan="4" align="right"><strong>Method</strong></td><td align="left" colspan="2">
								<select name="method" id="" class="form-control">
									<option value="">Select Method</option>
									<option value="Cash">Cash</option>
									<option value="Cash">Credit</option>
								</select>
                            </td></tr>
                <tr class="tableInfo"><td colspan="4" align="right"><strong>Due</strong></td><td align="left" colspan="2"><input type='text'  class="form-control" id = "payment_due"  readonly></td></tr>
            </tbody>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
              </div>
          </div>
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
    $('#datepicker').datepicker({

    autoclose: true
    })
    })
      function sum() {
        var txtFirstNumberValue = document.getElementById('subTotal').value;
        var txtSecondNumberValue = document.getElementById('paidTotal').value;
        var result = parseInt(txtSecondNumberValue) - parseInt(txtFirstNumberValue);
        if (!isNaN(result)) {
            document.getElementById('payment_due').value = result;
        }
    }
    </script> 

    <link rel="stylesheet" href="{{ asset('js/jquery-ui.css') }}" type="text/css" />
    <!-- jQuery UI 1.11.4 -->
   <script src="{{asset('js/jquery-migrate.min.js')}}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    

    <script type="text/javascript">

    function in_array(search, array)
    {
    for (i = 0; i < array.length; i++)
    {
    if(array[i] ==search )
    {
    return true;
    }
    }
    return false;
    }

    var stack = [];
	$(document).keypress(function(e) {
		if(e.which == 13) {
			e.preventDefault();
			return false;
		}
	});
	$( "#search" ).autocomplete({
		source: function(request, response) {
			$.ajax({
				url: '{{url('admin/purchase/item-search')}}',
				dataType: "json",
				type: "get",
				data: {

				search: request.term
				},
				success: function(data){
//Start
if(data.status_no == 1){
	$("#val_item").html();
	var data = data.items;
	$('#ui-id-2').css('display','none');
	response( $.map( data, function( item ) {
		return {
			id: item.id,
			code: item.code,
			value: item.name,
			unit: item.unit,
			cost_price: item.cost_price,
			sales_price: item.sales_price,
			initial_stock: item.initial_stock,
			total_stock: item.total_stock
		}
	}));
}else{
	$('.ui-menu-item').remove();
	$('.addedLi').remove();
	$("#ui-id-1").append($("<li class='addedLi'>").text(data.message));
	var searchVal = $("#search").val();
	if(searchVal.length > 0){
		$("#ui-id-2").css('display','block');
	}else{
		$("#ui-id-2").css('display','none');
	}
}
}
})
	},

		select: function(event, ui) {
			var e = ui.item;
			if(e.id) {
				if(!in_array(e.id, stack))
				{
					stack.push(e.id);

					var taxAmount = (e.cost_price*1);

					var new_row = '<tr class="nr" id="rowid'+e.id+'">'+

					'<td>'+ e.value +'<input type="hidden" value=""></td><input type="hidden" name="product_id[]" value="'+e.id+'"></td>'+

					'<td><input min="0"  type="text" data-id = "'+e.id+'" id="rate_id_'+e.id+'" value="'+ e.cost_price +'" name="price[]"  class="form-control text-center unitprice"></td>'+

					'<td><input class="form-control text-center no_units" data-id="'+e.id+'" data-rate="'+ e.cost_price +'" type="text" id="qty_'+e.id+'" name="quantity[]" value="1" data-tax ="'+e.rate+'">'+

					'<td><input class="form-control text-center amount" type="text" id="amount_'+e.id+'" value="'+e.cost_price+'"  readonly></td>'+

					'<td class="text-center"><button id="'+e.id+'" class="btn btn-xs btn-danger delete_item"><i class="fa fa-trash"></i></button></td>'+
					'</tr>';

					$(new_row).insertAfter($('table tr.dynamicRows:last'));


// Calculate subtotal
var subTotal = calculateSubTotal();
$("#subTotal").val(subTotal);

$('.tableInfo').show();

} else {
	$('#qty_'+e.id).val( function(i, oldval) {
		return ++oldval;
	});
	var q = $('#qty_'+e.id).val();
	var r = $("#rate_id_"+e.id).val();

	$('#amount_'+e.id).val( function(i, amount) {
		var itemPrice = (q * r);
		return itemPrice;
	});


// Calculate subTotal
var subTotal = calculateSubTotal();
$("#subTotal").val(subTotal);
// Calculate GrandTotal

}

$(this).val('');
$('#val_item').html('');
return false;
}
},
minLength: 1,
autoFocus: true
});

	$(document).ready(function() {
		$(window).keydown(function(event){
			if(event.keyCode == 13) {
				event.preventDefault();
				return false;
			}
		});
	});

// price calcualtion with quantity
$(document).ready(function(){
	$('.tableInfo').hide();
});


$(document).on('keyup', '.no_units', function(ev){
	var id = $(this).attr("data-id");
	var qty = parseInt($(this).val());

	var rate = $("#rate_id_"+id).val();

	var price = calculatePrice(qty,rate);

	$("#amount_"+id).val(price);

// Calculate subTotal
var subTotal = calculateSubTotal();
$("#subTotal").val(subTotal);


});

// calculate amount with unit price
$(document).on('keyup', '.unitprice', function(ev){

	var unitprice = parseFloat($(this).val());

	var id = $(this).attr("data-id");

	var qty = $("#qty_"+id).val();
//console.log(qty);
var rate = $("#rate_id_"+id).val();

var price = calculatePrice(qty,rate);
$("#amount_"+id).val(price);

// Calculate subTotal
var subTotal = calculateSubTotal();
$("#subTotal").val(subTotal);


});

// Delete item row
$(document).ready(function(e){
	$('#purchaseInvoice').on('click', '.delete_item', function() {
		var v = $(this).attr("id");
		stack = jQuery.grep(stack, function(value) {
			return value != v;
		});
		$(this).closest("tr").remove();
		var amountByRow = $('#amount_'+v).val();
		var subTotal = calculateSubTotal();
		$("#subTotal").html(subTotal);

	});
});

//hitung jumalh sub total
function calculateSubTotal (){
	var subTotal = 0;
	$('.amount').each(function() {
		subTotal += parseInt($(this).val());
	});
	return subTotal;
}

//hitung harga product
function calculatePrice (qty,rate){
	var price = (qty*rate);
	return price;
}

// Item form validation
$('#purchaseForm').validate({
	rules: {
		supplier_id: {
			required: true
		},
		purchase_date:{
			required: true
		}
	}
});

// Item not found error
$("#search").on('keyup', function(){
	var searchVal = $("#search").val();
	if(searchVal.length > 0){
		$("#ui-id-2").css('display','block');
	}else{
		$("#ui-id-2").css('display','none');
	}
});

    </script>


@endsection