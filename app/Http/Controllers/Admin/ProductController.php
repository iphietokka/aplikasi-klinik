<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Model\Category;
use App\Model\Product;

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
        $product->sale_price = $request->get('sale_price') / 1;
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
        //
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
        $products = Product::find($id);
        $categories = Category::pluck('name', 'id');
        return view('admin.' . $title . '.edit', compact('title', 'products', 'categories'));
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
}
