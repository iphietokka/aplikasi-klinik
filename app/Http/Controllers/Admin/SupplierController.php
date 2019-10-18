<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Model\Supplier;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->title = "supplier";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title;
        $data = Supplier::orderBy('name', 'ASC')->get();
        return view('admin.' . $title . '.index', compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        $data = new Supplier();
        $data->name = $request->get('name');
        $data->address = $request->get('address');
        $data->phone = $request->get('phone');
        if ($data->save()) {
            return redirect('admin/' . $this->title)->with('success', 'Data Berhasil Disimpan!!');
        } else {
            return redirect()->back()->with('error', 'Terjadi Kesalahan!!');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $suppliers = Supplier::find($data['id']);
        if ($suppliers->update($data)) {
            return redirect('admin/' . $this->title)->with('success', 'Data Berhasil Di Update!!');
        } else {
            return redirect()->back()->with('error', 'Terjadi Kesalahan!!');
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
        $data = Supplier::find($id);
        if ($data->delete()) {
            return redirect('admin/' . $this->title)->with('success', 'Data Berhasil Di Hapus!!');
        } else {
            return redirect()->back()->with('error', 'Terjadi Kesalahan!!');
        }
    }
}
