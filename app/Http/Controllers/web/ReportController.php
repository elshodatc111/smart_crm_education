<?php

namespace App\Http\Controllers\web;

use App\Exports\{UserPaymenmtExport,UsersExport};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
            $fileName = 'BarchaTalabalar_' . now()->format('Y_m_d_His') . '.xlsx';
            return Excel::download(new UsersExport, $fileName);
        }elseif($report_type == 'user_payment'){
            $fileName = 'TalabalarTolovlari_' . now()->format('Y_m_d_His') . '.xlsx';
            return Excel::download(new UserPaymenmtExport, $fileName);
        }elseif($report_type == 'user_history'){
            $fileName = 'TalabaTarixi' . now()->format('Y_m_d_His') . '.xlsx';
            
        }elseif($report_type == 'user_davomad'){
            $fileName = 'TalabaDavomadTarixi' . now()->format('Y_m_d_His') . '.xlsx';
            
        }elseif($report_type == 'user_bonus'){
            $fileName = 'TalabaChegirmaliBonuslarTarixi' . now()->format('Y_m_d_His') . '.xlsx';
            
        }
        return back()->with('success', 'Hisobot mofaqiyatli yuklandi ✅');
    }

}
