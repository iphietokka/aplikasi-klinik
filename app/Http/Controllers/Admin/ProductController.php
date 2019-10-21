<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\Category;
use App\Model\Product;
use App\Model\PurchaseDetail;
use App\Model\SalesDetail;
use App\Model\Stock;
use Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->title = "product";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title;
        $data = Product::with('category')->orderBy('name', 'ASC')->get();
        return view('admin.' . $title . '.index', compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $categories = Category::pluck('name', 'id');
        return view('admin.' . $title . '.create', compact('title', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = new Product();
        $product->name = $request->get('name');
        $product->code = $request->get('code');
        $product->category_id = $request->get('category_id');
        $product->details = $request->get('details');
        $product->cost_price = $request->get('cost_price') / 1;
        $product->sales_price = $request->get('sales_price') / 1;
        $product->initial_stock = $request->get('initial_stock') / 1;
        $product->total_stock = $request->get('initial_stock') / 1;
        $product->unit = $request->get('unit');
        $product->user_id = Auth::user()->id;
        if ($product->save()) {
            return redirect('admin/' . $this->title)->with('success', 'Data Product Berhasil Disimpan!!');
        } else {
            return redirect('admin/' . $this->title)->with('erorr', 'Terjadi Kesalahan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = $this->title;
        $products = Product::with('category')->orderBy('name', 'asc')->find($id);
        $data = PurchaseDetail::with(['purchase'])->where('product_id', $id)->orderBy('id', 'DESC')->get();
        $datas = SalesDetail::with(['sales'])->where('product_id', $id)->orderBy('id', 'DESC')->get();
        return view('admin.' . $title . '.show', compact('data', 'datas', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = $this->title;
        $data = Product::find($id);
        $categories = Category::pluck('name', 'id');
        return view('admin.' . $title . '.edit', compact('title', 'data', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $model = $request->all();
        $products = Product::find($model['id']);
        $products->total_stock = ($products->total_stock / 1) + (($request->initial_stock / 1) - ($products->initial_stock / 1));
        $products->initial_stock = $request->initial_stock / 1;
        $products->user_id = Auth::user()->id;
        if ($products->update($model)) {
            return redirect('admin/' . $this->title)->with('success', 'Data Product Berhasil Di Update!');
        } else {
            return redirect('admin/' . $this->title)->with('erorr', 'Terjadi Kesalahan!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function stockCorrection(Request $request)
    {
        $id = $request->get('product_id');
        $product = Product::find($id);
        $detail = new Stock();
        $detail->product_id = $id;
        $detail->quantity = $request->quantity / 1;
        $detail->description = "Stock Correction";
        $detail->type = "correction";
        $detail->save();

        //UPDATE STOK TOTAL BARANG
        $product = Product::find($request->product_id);
        $product->total_stock = ($product->total_stock / 1) + ($request->quantity / 1);
        if ($product->save()) {
            return redirect('admin/' . $this->title)->with('success', 'Product Price Updated!');
        }
    }

    public function updatePrice(Request $request, $id)
    {
        $id = $request->get('product_id');
        $product = Product::find($id);
        $product->cost_price = $request->get('cost_price');
        $product->sales_price = $request->get('sales_price');
        if ($product->save()) {
            return redirect('admin/' . $this->title)->with('success', 'Update Harga Berhasil!!');
        } else {
            return redirect('admin/' . $this->title)->with('error', 'Terjadi Kesalahan!!');
        }
    }

    public function import()
    {
        Excel::import(new ProductImport, request()->file('file'));
        return redirect('admin/' . $this->title)->with('success', 'Product Berhasil Di Tambah');
    }
}
