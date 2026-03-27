<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller{

    public function users(){
        return view('report.users');
    }

    public function payment(){
        return view('report.payment');
    }

    public function groups(){
        return view('report.groups');
    }

    public function message(){
        return view('report.message');
    }

    public function export(Request $request){
        $report_type = $request->report_type;
        if($report_type == 'all_user'){
            $fileName = 'foydalanuvchilar_' . now()->format('Y_m_d_His') . '.xlsx';
            return Excel::download(new UsersExport, $fileName);
        }
        return back()->with('success', 'Hisobot mofaqiyatli yuklandi ✅');
    }

}
