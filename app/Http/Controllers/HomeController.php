<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public funtion freeDateTime(Request $request) {
        return Validator::make($request, [
            'name' => 'required|string|max:100',
            'date' => 'required|date',
            'time' => 'required',
        ]);
    }
}
