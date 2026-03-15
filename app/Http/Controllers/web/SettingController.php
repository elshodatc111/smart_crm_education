<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller{

    public function message(){
        return view('setting.message');
    }

    public function room(){
        return view('setting.room');
    }

    public function payment(){
        return view('setting.payment');
    }

    public function cours(){
        return view('setting.cours');
    }

    public function region(){
        return view('setting.region');
    }

    






}
