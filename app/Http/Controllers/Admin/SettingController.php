<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\Model\Setting;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->title = "settings";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title;
        $data = Setting::orderBy('id', 'desc')->get();

        return view('admin.' . $title . '.index', compact('title', 'data'));
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
        $data = Setting::find($model['id']);
        if ($data->update($model)) {
            return redirect('admin/' . $this->title)->with('success', 'Update Data Berhasil');
        }
    }
}
