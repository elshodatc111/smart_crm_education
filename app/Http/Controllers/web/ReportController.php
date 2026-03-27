<?php

namespace App\Http\Controllers\web;

use App\Exports\{AllGroupsDataExport, AllGroupsExport, BalansHistoryExport, EmploesPaymentExport, GroupUserExport, KassaHistoryExport, TestNatijaExport, UserChegirmaHistoryExport, UserDavomadExport, UserHistoryExport, UserPaymenmtExport,UsersExport};
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
            return Excel::download(new UserHistoryExport, $fileName);
        }elseif($report_type == 'user_davomad'){
            $fileName = 'TalabaDavomadTarixi' . now()->format('Y_m_d_His') . '.xlsx';
            return Excel::download(new UserDavomadExport, $fileName);
        }elseif($report_type == 'user_bonus'){
            $fileName = 'TalabaChegirmaliBonuslarTarixi' . now()->format('Y_m_d_His') . '.xlsx';
            return Excel::download(new UserChegirmaHistoryExport, $fileName);
        }elseif($report_type == 'emploes_payment'){
            $fileName = 'HodimlarIshHaqi' . now()->format('Y_m_d_His') . '.xlsx';
            return Excel::download(new EmploesPaymentExport, $fileName);
        }elseif($report_type == 'kasssHistory'){
            $fileName = 'KassaTarixi' . now()->format('Y_m_d_His') . '.xlsx';
            return Excel::download(new KassaHistoryExport, $fileName);
        }elseif($report_type == 'balans_history'){
            $fileName = 'BalansTarixi' . now()->format('Y_m_d_His') . '.xlsx';
            return Excel::download(new BalansHistoryExport, $fileName);
        } 
        elseif($report_type == 'all_groups'){
            $fileName = 'BarchaGuruhlar' . now()->format('Y_m_d_His') . '.xlsx';
            return Excel::download(new AllGroupsExport, $fileName);
        }elseif($report_type == 'all_group_data'){
            $fileName = 'BarchaDarsKunlari' . now()->format('Y_m_d_His') . '.xlsx';
            return Excel::download(new AllGroupsDataExport, $fileName);
        }elseif($report_type == 'all_quez_history'){
            $fileName = 'TestNatijalari' . now()->format('Y_m_d_His') . '.xlsx';
            return Excel::download(new TestNatijaExport, $fileName);
        }elseif($report_type == 'all_group_user'){
            $fileName = 'BarchaGuruhTalanalariTarixi' . now()->format('Y_m_d_His') . '.xlsx';
            return Excel::download(new GroupUserExport, $fileName);
        }

        elseif($report_type == 'all_group_user'){
            $fileName = 'BarchaGuruhTalanalariTarixi' . now()->format('Y_m_d_His') . '.xlsx';
            
        }
        return back()->with('success', 'Hisobot mofaqiyatli yuklandi ✅');
    }

}
