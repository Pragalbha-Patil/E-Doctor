<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\DoctorModel;
use App\AppModel;
use DB;

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

    public function view() {
        $user = auth()->user()->name;
        if($user) {
            $result = DB::table('appointments')->get();
            return view('show')->with('data', $result);
        }
        else {
            return redirect()->route('/');
        }
    }

    public function deleteById($id) {
        $actual_id = base64_decode(urldecode($id));
        $model = AppModel::findOrfail($actual_id);
        $model->delete();
        return redirect()->route('appointments')->with('msg', 'Record deleted successfully!');
    }
}
