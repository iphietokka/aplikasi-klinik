<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use App\User;
use App\Model\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->title = "user";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title;
        $data = User::with('roles')->orderBy('name', 'ASC')->get();
        $roles = Role::pluck('name', 'id');
        return view('admin.' . $title . '.index', compact('title', 'data', 'roles'));
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
    public function store(UsersRequest $request)
    {
        $data = new User();
        $data->name = $request->get('name');
        $data->username = $request->get('username');
        $data->active = $request->active;
        $data->role_id = $request->get('role_id');
        $data->password = bcrypt($request->password);
        if ($data->save()) {
            return redirect('admin/' . $this->title)->with('success', 'Data Berhasil Di Tambah');
        } else {
            return redirect()->back()->with('error', "Terjadi Kesalahan, Data Gagal Tersimpan");
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
        $model = $request->all();
        $data = User::find($model['id']);
        if ($request->password == '') {
            $input = $request->except('password');
        } else {
            $input = $request->all();
        }
        if (!$request->password == '') {
            $input['password'] = bcrypt($request->password);
        }
        if ($data->update($input)) {
            return redirect('admin/' . $this->title)->with('success', 'Data Successfully Updated');
        } else {
            return redirect()->back()->with('error', 'Something Went Wrong!!');
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
        $data = User::find($id);
        if ($data->delete()) {
            return redirect('admin/' . $this->title)->with('success', 'Data Berhasil Di Hapus');
        } else {
            return redirect()->back()->with('error', "Terjadi Kesalahan, Data Gagal Terhapus");
        }
    }
}
