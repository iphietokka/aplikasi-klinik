<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->check() && Auth::user()->roles->name == 'admin') {
            return redirect('/admin');
        } elseif (auth()->check() && Auth::user()->roles->name == 'user') {
            return Redirect('/user');
        } else {
            abort(404);
        }
    }
}
