<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\web\kassa\KassaChiqimRequest;
use App\Models\Balans;
use App\Models\BalansHistory;
use App\Models\Kassa;
use App\Models\KassaHistory;
use App\Models\KassaSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KassaController extends Controller{
    public function kassa(){
        $kassa = Kassa::getSettings();
        $history = KassaHistory::where('status','pending')->get();
        return view('kassa.kassa',compact('kassa','history'));
    }
    public function chiqim(KassaChiqimRequest $request){
        DB::transaction(function () use ($request) {
            $kassa = Kassa::first();
            $amount = $request->amount;
            if ($request->type === 'output_cash') {
                $kassa->decrement('cash', $amount);
                $kassa->increment('output_cash_pending',$amount);
            }
            if ($request->type === 'output_card') {
                $kassa->decrement('card', $amount);
                $kassa->increment('output_card_pending',$amount);
            }
            if ($request->type === 'cost_cash') {
                $kassa->decrement('cash', $amount);
                $kassa->increment('cost_cash_pending',$amount);
            }
            if ($request->type === 'cost_card') {
                $kassa->decrement('card', $amount);
                $kassa->increment('cost_card_pending',$amount);
            }
            KassaHistory::create([
                'amount' => $amount,
                'type' => $request->type,
                'description' => $request->description,
                'manager_id' => Auth::id(),
                'status' => 'pending',
            ]);
        });
        return back()->with('success', 'Chiqim muvaffaqiyatli bajarildi ✅');
    }
    public function cancel($id){
        DB::transaction(function () use ($id) {
            $history = KassaHistory::findOrFail($id);
            $kassa = Kassa::first();
            $amount = $history->amount;
            if ($history->type === 'output_cash') {
                $kassa->increment('cash', $amount);
                $kassa->decrement('output_cash_pending',$amount);
            }
            if ($history->type === 'output_card') {
                $kassa->increment('card', $amount);
                $kassa->decrement('output_card_pending',$amount);
            }
            if ($history->type === 'cost_cash') {
                $kassa->increment('cash', $amount);
                $kassa->decrement('cost_cash_pending',$amount);
            }
            if ($history->type === 'cost_card') {
                $kassa->increment('card', $amount);
                $kassa->decrement('cost_card_pending',$amount);
            }
            $history->update([
                'status' => 'canceled',
                'admin_id' => Auth::id(),
            ]);
        });
        return back()->with('success', 'Bekor qilindi ❌');
    }
    public function approve($id){
        DB::transaction(function () use ($id) {
            $history = KassaHistory::findOrFail($id);
            if (in_array($history->status, ['success', 'canceled'])) {
                return;
            }
            $amount = $history->amount;
            $kassa = Kassa::first();
            $setting = KassaSetting::first();
            $balans = Balans::getBalans();
            $exson_cash = ($setting->cash_exson / 100) * $amount;
            $salary_cash = ($setting->cash_salary / 100) * $amount;
            $exson_card = ($setting->card_exson / 100) * $amount;
            $salary_card = ($setting->card_salary / 100) * $amount;
            if ($history->type === 'output_cash') {
                $kassa->decrement('output_cash_pending', $amount);
                $net = $amount - $exson_cash - $salary_cash;
                $balans->increment('cash', $net);
                BalansHistory::create([
                    'type' => 'kirim_cash',
                    'amount' => $net,
                    'description' => $history->description,
                    'user_id' => $history->manager_id,
                    'admin_id' => Auth::id()
                ]);
                $balans->increment('cash_salary', $salary_cash);
                if($salary_cash>0){
                    BalansHistory::create([
                        'type' => 'kirim_ish_haqi_cash',
                        'amount' => $salary_cash,
                        'description' => $history->description,
                        'user_id' => $history->manager_id,
                        'admin_id' => Auth::id()
                    ]);
                }
                $balans->increment('cash_exson', $exson_cash);
                if($exson_cash>0){
                    BalansHistory::create([
                        'type' => 'kirim_exson_cash',
                        'amount' => $exson_cash,
                        'description' => $history->description,
                        'user_id' => $history->manager_id,
                        'admin_id' => Auth::id()
                    ]);
                }
            }
            if ($history->type === 'output_card') {
                $kassa->decrement('output_card_pending', $amount);
                $net = $amount - $exson_card - $salary_card;
                $balans->increment('card', $net);
                BalansHistory::create([
                    'type' => 'kirim_card',
                    'amount' => $net,
                    'description' => $history->description,
                    'user_id' => $history->manager_id,
                    'admin_id' => Auth::id()
                ]);
                $balans->increment('card_salary', $salary_card);
                if($salary_card>0){
                    BalansHistory::create([
                        'type' => 'kirim_ish_haqi_card',
                        'amount' => $salary_card,
                        'description' => $history->description,
                        'user_id' => $history->manager_id,
                        'admin_id' => Auth::id()
                    ]);
                }
                $balans->increment('card_exson', $exson_card);
                if($exson_card>0){
                    BalansHistory::create([
                        'type' => 'kirim_exson_card',
                        'amount' => $exson_card,
                        'description' => $history->description,
                        'user_id' => $history->manager_id,
                        'admin_id' => Auth::id()
                    ]);
                }
            }
            if ($history->type === 'cost_cash') {
                $kassa->decrement('cost_cash_pending', $amount);
                BalansHistory::create([
                    'type' => 'xarajat_kassa_cash',
                    'amount' => $amount,
                    'description' => $history->description,
                    'user_id' => $history->manager_id,
                    'admin_id' => Auth::id()
                ]);
            }
            if ($history->type === 'cost_card') {
                $kassa->decrement('cost_card_pending', $amount);
                BalansHistory::create([
                    'type' => 'xarajat_kassa_card',
                    'amount' => $amount,
                    'description' => $history->description,
                    'user_id' => $history->manager_id,
                    'admin_id' => Auth::id()
                ]);
            }
            $history->update([
                'status' => 'success',
                'admin_id' => Auth::id(),
            ]);
        });
        return back()->with('success', 'Tasdiqlandi ✅');
    }
}
