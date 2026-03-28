<?php

namespace App\Http\Controllers;

use App\Exports\ImportErrorsExport;
use App\Imports\StudentsImport;
use App\Imports\UsersHistoryImport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class UploadController extends Controller{
    public function uploadViwe(){
        return view('upload.index');
    }

    public function uploadUsers(Request $request) {
        $request->validate([
            'excel' => 'required|mimes:xlsx,xls|max:500',
        ]);
        $import = new UsersImport;
        Excel::import($import, $request->file('excel'));
        if (count($import->errors) > 0) {
            return Excel::download(
                new ImportErrorsExport($import->errors), 
                'import_errors_users_' . now()->format('Y_m_d_H_i') . '.xlsx'
            );
        }
        return back()->with('success', "{$import->successCount} ta foydalanuvchi yuklandi.");
    }

    public function uploadUserHistory(Request $request) {
        $request->validate([
            'excel' => 'required|mimes:xlsx,xls|max:500',
        ]);
        $import = new UsersHistoryImport;
        Excel::import($import, $request->file('excel'));
        if (count($import->errors) > 0) {
            return Excel::download(
                new ImportErrorsExport($import->errors), 
                'import_errors_users_history_' . now()->format('Y_m_d_H_i') . '.xlsx'
            );
        }
        return back()->with('success', "{$import->successCount} ta foydalanuvchi tarixi yuklandi.");
    }
    
}
