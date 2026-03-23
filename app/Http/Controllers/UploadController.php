<?php

namespace App\Http\Controllers;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class UploadController extends Controller{
    public function uploadViwe(){
        return view('upload.index');
    }

    public function uploadUsers(Request $request) {
        $request->validate([
            'excel' => 'required|mimes:xlsx|max:500'
        ]);
        try {
            $import = new StudentsImport;
            Excel::import($import, $request->file('excel'));
            $results = $import->stats;
            return back()->with('success', 
                "Jami qatorlar: {$results['all']}. " . 
                "Muvaffaqiyatli: {$results['success']}. " . 
                "Xatolik (mavjud foydalanuvchilar): {$results['error']}."
            );
        } catch (\Exception $e) {
            return back()->withErrors(['excel' => $e->getMessage()]);
        }
    }
}
