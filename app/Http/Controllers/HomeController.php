<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\DoctorModel;
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

    public function freeDateTime(Request $request) {
        // return Validator::make($request, [
        //     'name' => 'required|string|max:100',
        //     'date' => 'required|date',
        //     'time' => 'required',
        // ]);
        
        $model = new DoctorModel;
        $model->dname = $request->name;
        $model->date = $request->date;
        $model->time = $request->time;
        $model->status = 0;
        $model->save();
        return redirect()->route('home')->with('msg', 'Record added successfully!');

    }
}
