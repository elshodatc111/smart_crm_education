<?php

namespace App\Http\Controllers\wen;

use App\Http\Controllers\Controller;
use App\Models\DamOlishKuni;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DamOlishController extends Controller{

    public function damOlish(){
        DB::transaction(function () {
            DamOlishKuni::where('title', 'Yakshanba')->whereDate('data', '<', now())->delete();
            $lastDate = DamOlishKuni::max('data');
            $start = $lastDate ? Carbon::parse($lastDate)->addDay() : now();
            $end = now()->copy()->addYear();
            if ($start > $end) { return; }
            $dates = [];
            for ($date = $start->copy(); $date <= $end; $date->addDay()) {
                if ($date->dayOfWeek === Carbon::SUNDAY) {
                    $exists = DamOlishKuni::whereDate('data', $date)->exists();
                    if (!$exists) {
                        $dates[] = [
                            'data' => $date->toDateString(),
                            'title' => 'Yakshanba',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }
            $holidays = [
                ['01-01', 'Yangi yil'],
                ['03-08', 'Xotin-qizlar kuni'],
                ['03-21', 'Navro‘z'],
                ['05-09', 'Xotira va qadrlash kuni'],
                ['09-01', 'Mustaqillik kuni'],
                ['10-01', 'O‘qituvchilar kuni'],
                ['12-08', 'Konstitutsiya kuni'],
            ];
            foreach ($holidays as [$md, $title]) {
                [$month, $day] = explode('-', $md);
                $year = now()->year;
                for ($i = 0; $i <= 1; $i++) {
                    $date = Carbon::create($year + $i, $month, $day);
                    if ($date >= now() && $date <= $end) {
                        $exists = DamOlishKuni::whereDate('data', $date)->exists();
                        if (!$exists) {
                            $dates[] = [
                                'data' => $date->toDateString(),
                                'title' => $title,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        }
                    }
                }
            }
            if (!empty($dates)) {
                DamOlishKuni::insert($dates);
            }
        });
        $dam_olish_kunlar = DamOlishKuni::orderBy('data', 'asc')->get();
        return view('setting.damOlish', compact('dam_olish_kunlar'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'data' => 'required|date|after_or_equal:today',
            'title' => 'required|string|max:255',
        ]);
        DamOlishKuni::create($data);

        return back()->with('success', 'Dam olish kuni qo‘shildi ✅');
    }
}
