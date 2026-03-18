<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Balans\BalansChiqimRequest;
use App\Http\Requests\Web\Balans\BalansConvertRequest;
use App\Http\Requests\Web\Balans\ExsonChiqimRequest;
use App\Models\Balans;
use App\Models\BalansHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BalansController extends Controller{

    public function balans(){
        $balans = Balans::getBalans();
        $history45 = BalansHistory::where('created_at', '>=', Carbon::now()->subDays(45))->orderBy('id', 'desc')->get();
        return view('balans.balans',compact('balans','history45'));
    }

    public function balansChiqim(BalansChiqimRequest $request){
        DB::transaction(function () use ($request) {
            $balans = Balans::getBalans();
            if($request->payment_type == 'cash'){
                $balans->decrement('cash', $request->amount);
            }elseif($request->payment_type == 'card'){
                $balans->decrement('card', $request->amount);
            }
            if($request->category == 'daromad'){
                BalansHistory::create([
                    'type' => $request->payment_type == 'cash'?'chiqim_cash':'chiqim_card',
                    'amount' => $request->amount,
                    'description' => $request->description,
                    'user_id' => Auth::id(),
                    'admin_id' => Auth::id()
                ]);
            }
            elseif($request->category == 'xarajat'){
                BalansHistory::create([
                    'type' => $request->payment_type == 'cash'?'xarajat_balans_cash':'xarajat_balans_card',
                    'amount' => $request->amount,
                    'description' => $request->description,
                    'user_id' => Auth::id(),
                    'admin_id' => Auth::id()
                ]);
            }
        });
        return back()->with('success', 'Amaliyot bajarildi ✅');
    }

    public function balansConvert(BalansConvertRequest $request){
        DB::transaction(function () use ($request) {
            $balans = Balans::getBalans();
            if($request->transfer_type == 'balans_to_ishhaqi'){
                if($request->payment_type=='cash'){
                    $balans->decrement('cash', $request->amount);
                    $balans->increment('cash_salary', $request->amount);
                    $typing = "cash_to_ishhaqi";
                }else{
                    $balans->decrement('card', $request->amount);
                    $balans->increment('card_salary', $request->amount);
                    $typing = "card_to_ishhaqi";
                }
            }else{
                if($request->payment_type=='cash'){
                    $balans->decrement('cash_salary', $request->amount);
                    $balans->increment('cash', $request->amount);
                    $typing = "ishhaqi_pay_cash";
                }else{
                    $balans->decrement('card_salary', $request->amount);
                    $balans->increment('card', $request->amount);
                    $typing = "ishhaqi_pay_card";
                }
            }
            BalansHistory::create([
                'type' => $typing,
                'amount' => $request->amount,
                'description' => $request->description,
                'user_id' => Auth::id(),
                'admin_id' => Auth::id()
            ]);
        });
        return back()->with('success', 'Amaliyot bajarildi ✅');
    }

    public function exsonChiqim(ExsonChiqimRequest $request){
        DB::transaction(function () use ($request) {
            $balans = Balans::getBalans();
            if($request->payment_type == 'cash'){
                $balans->decrement('cash_exson', $request->amount);
            }else{
                $balans->decrement('card_exson', $request->amount);
            }
            BalansHistory::create([
                'type' => $request->payment_type=='cash'?"chiqim_exson_cash":"chiqim_exson_card",
                'amount' => $request->amount,
                'description' => $request->description,
                'user_id' => Auth::id(),
                'admin_id' => Auth::id()
            ]);
        });
        return back()->with('success', 'Amaliyot bajarildi ✅');
    }

}
