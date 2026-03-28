<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChartController extends Controller{

    public function tashrif(){
        return view('chart.tashrif');
    }

    public function payment(){
         return view('chart.payment');    
    }

}
