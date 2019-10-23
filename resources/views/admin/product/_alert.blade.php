<!-- Messages: style can be found in dropdown.less-->
<?php
$product_alert = App\Model\Product::orderBy('id', 'asc')->where('total_stock', '<' , 10);
?>
<li class="dropdown messages-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-envelope-o"></i>
        <span class="label label-danger">{{$product_alert->count()}}</span>
    </a>
<ul class="dropdown-menu">
        <li class="header">Alert Product</li>
<li>
    <ul class="menu">
        @foreach ($product_alert->take(5)->get() as $product_alert)
            <li><a><h6>{{$product_alert->name}} =  {{$product_alert->total_stock}}</h6></a></li>
        @endforeach
    </ul>
</li>
       <li class="footer"><a href="{{ route('product') }}">See All Products</a></li>
</ul>
</li>