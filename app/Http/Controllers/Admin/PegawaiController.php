<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PegawaiRequest;
use App\Model\Employee;
use App\Model\Unit;

class PegawaiController extends Controller
{
    public function __construct()
    {
        $this->title = "pegawai";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title;
        $data = Employee::orderBy('name', 'ASC')->get();
        $units = Unit::pluck('name', 'id');
        return view('admin/' . $title . '.index', compact('title', 'data', 'units'));
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
    public function store(PegawaiRequest $request)
    {
        $data = new Employee();
        $data->name = $request->get('name');
        $data->address = $request->get('address');
        $data->phone = $request->get('phone');
        $data->unit_id = $request->get('unit_id');
        $data->status = $request->get('status');
        if ($data->save()) {
            return redirect('admin/' . $this->title)->with('success', 'Data Berhasil DiSimpan');
        } else {
            return redirect()->back()->with('error', 'Terjadi Kesalahan, Gagal Menyimampan Data');
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
        $employees = Employee::find($data['id']);
        if ($employees->update($data)) {
            return redirect('admin/' . $this->title)->with('success', 'Update Data Berhasil');
        } else {
            return redirect()->back()->with('error', 'Terjadi Kesalahan, Gagal Update Data');
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
        $data = Employee::find($id);
        if ($data->delete()) {
            return redirect('admin/' . $this->title)->with('success', 'Delete Data Berhasil');
        } else {
            return redirect()->back()->with('error', 'Terjadi Kesalahan, Gagal Delete Data');
        }
    }
}
