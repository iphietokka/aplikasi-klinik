<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Unit;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->title = "unit";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title;
        $units = Unit::orderBy('name', 'ASC')->get();
        return view('admin.' . $title . '.index', compact('title', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Unit();
        $data->name = $request->get('name');
        if ($data->save()) {
            return redirect('admin/' . $this->title)->with('success', 'Data Berhasil di Tambah');
        } else {
            return redirect('admin/' . $this->title)->with('error', 'Terjadi Kesalahan!!');
        }
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
        $model = $request->all();
        $data = Unit::find($model['id']);
        if ($data->update($model)) {
            return redirect('admin/' . $this->title)->with('success', 'Data Berhasil Update');
        } else {
            return redirect('admin/' . $this->title)->with('error', 'Terjadi Kesalahan');
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
        $data = Unit::find($id);
        if ($data->delete()) {
            return redirect('admin/' . $this->title)->with('success', 'Data Berhasil di Hapus');
        } else {
            return redirect('admin/' . $this->title)->with('error', 'Terjadi Kesalahan');
        }
    }
}
