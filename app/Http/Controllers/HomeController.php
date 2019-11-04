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

        $request->validate([
            'name' => 'bail|required|string|max:100',
            'date' => 'bail|required|date|after_or_equal:today',
            'time' => 'bail|required|between:8,22',
        ],
        [
            'time.between' => 'The clinic is only open between 8AM to 10PM',
            'date.after_or_equal' => 'Date cannot be before today'
        ]
        );
        
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
