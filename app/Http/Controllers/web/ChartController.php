<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BalansHistory;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use App\Models\UserPayment;
use Carbon\Carbon;

class ChartController extends Controller{

    public function getLast12Months(){
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $months[] = Carbon::now()->subMonths($i)->format('Y-m');
        }
        return $months;
    }

    public function activeUser(){
        $getLast12Months = $this->getLast12Months();
        $aktive = [];
        foreach ($getLast12Months as $value) {
            $Groups = Group::where('start_lesson','>=',$value.'-01')->where('start_lesson','<=',$value.'-31')->get();
            $userid = [];
            foreach ($Groups as $v) {
                $groupUsers = GroupUser::where('group_id',$v->id)->get();
                foreach ($groupUsers as $value2) {
                    if(!in_array($value2->user_id, $userid)){
                        $userid[] = $value2->user_id;
                    }
                }
            }
            $aktive[$value] = count($userid);
        }
        return [
            'date' => array_keys($aktive),
            'active' => array_values($aktive)
        ];
    }

    public function getLast5Weeks(){
        $weeks = [];
        for ($i = 0; $i < 5; $i++) {
            $date = Carbon::now()->subWeeks($i);
            $startOfWeek = $date->copy()->startOfWeek()->format('Y-m-d');
            $endOfWeek = $date->copy()->endOfWeek()->format('Y-m-d');
            $weeks[] = [
                'start' => $startOfWeek,
                'end'   => $endOfWeek,
                'label' => Carbon::parse($startOfWeek)->format('d.m') . ' - ' . Carbon::parse($endOfWeek)->format('d.m'),
                'full_range' => $startOfWeek . ' - ' . $endOfWeek
            ];
        }
        return array_reverse($weeks);
    }

    public function weeks5chart(){
        $getLast5Weeks = $this->getLast5Weeks();
        $data = [];
        foreach ($getLast5Weeks as $key => $value) {
            $start = $value['start']." 00:00:00";
            $end = $value['end']." 23:59:59";
            $users = User::whereBetween('created_at', [$start, $end])->get();
            $data[$key]['visit'] = count($users);
            $groups = 0;
            $paycount = 0;
            $paysum = 0;
            foreach ($users as $v) {
                $UserGroups = GroupUser::where('user_id', $v->id)->where('is_active',true)->first(); 
                if($UserGroups){
                    $groups++;
                }
                $UserPayment = UserPayment::where('user_id', $v->id)->whereBetween('created_at', [$start, $end])->where('type', 'payment')->where('amount', '>', 0)->get();
                $paycount += count($UserPayment);
                $paysum += $UserPayment->sum('amount');
            }
            $data[$key]['groups'] = $groups;
            $data[$key]['payments'] = $paycount;
            $data[$key]['payment_sum'] = (int) $paysum;
        }
        return $data;
    }

    public function getLast6Months(){
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $months[] = Carbon::now()->subMonths($i)->format('Y-m');
        }
        return $months;
    }

    public function month6chart(){
        $getLast5Weeks = $this->getLast6Months();
        $data = [];
        foreach ($getLast5Weeks as $key => $value) {
            $start = $value."-01 00:00:00";
            $end = $value."-31 23:59:59";
            $users = User::whereBetween('created_at', [$start, $end])->get();
            $data[$key]['visit'] = count($users);
            $groups = 0;
            $paycount = 0;
            $paysum = 0;
            foreach ($users as $v) {
                $UserGroups = GroupUser::where('user_id', $v->id)->where('is_active',true)->first(); 
                if($UserGroups){
                    $groups++;
                }
                $UserPayment = UserPayment::where('user_id', $v->id)->whereBetween('created_at', [$start, $end])->where('type', 'payment')->where('amount', '>', 0)->get();
                $paycount += count($UserPayment);
                $paysum += $UserPayment->sum('amount');
            }
            $data[$key]['groups'] = $groups;
            $data[$key]['payments'] = $paycount;
            $data[$key]['payment_sum'] = (int) $paysum;
        }
        return $data;
    }

    public function tashrif(){
        $activeUser = $this->activeUser();
        $getLast5Weeks = $this->getLast5Weeks();
        $weeks5chart = $this->weeks5chart();
        $getLast6Months = $this->getLast6Months();
        $month6chart = $this->month6chart();
        return view('chart.tashrif', compact('activeUser', 'getLast5Weeks', 'weeks5chart', 'getLast6Months', 'month6chart'));
    }

    public function haftalikPayment(){
        $getLast5Weeks = $this->getLast5Weeks();
        $array = [];
        foreach ($getLast5Weeks as $key => $value) {
            $start = $value['start']." 00:00:00";
            $end = $value['end']." 23:59:59";
            $users = UserPayment::whereBetween('created_at', [$start, $end])->get();
            $cash = 0;
            $card = 0;
            $return = 0;
            $discount = 0;
            foreach ($users as $v) {
                if($v->type == 'payment' && $v->amount > 0 && $v->payment_type == 'cash'){
                    $cash += $v->amount;
                }elseif($v->type == 'payment' && $v->amount > 0 && $v->payment_type == 'card'){
                    $card += $v->amount;
                }elseif($v->type == 'payment' && $v->amount == 0){
                    $discount += $v->discount;
                }elseif($v->type == 'return' && $v->amount > 0){
                    $return += $v->amount;
                }                
            }
            $array[$key]['cash'] = (int) $cash;
            $array[$key]['card'] = (int) $card;
            $array[$key]['return'] = (int) $return;
            $array[$key]['discount'] = (int) $discount;
        }
        return $array;
    }

    public function getLast7Days(){
        $days = [];
        for ($i = 6; $i >= 0; $i--) {
            $days[] = Carbon::now()->subDays($i)->format('Y-m-d');
        }
        return $days;
    }

    public function kunlikPayment(){
        $getLast7Days = $this->getLast7Days();
        $array = [];
        foreach ($getLast7Days as $key => $value) {
            $start = $value." 00:00:00";
            $end = $value." 23:59:59";
            $users = UserPayment::whereBetween('created_at', [$start, $end])->get();
            $cash = 0;
            $card = 0;
            $return = 0;
            $discount = 0;
            foreach ($users as $v) {
                if($v->type == 'payment' && $v->amount > 0 && $v->payment_type == 'cash'){
                    $cash += $v->amount;
                }elseif($v->type == 'payment' && $v->amount > 0 && $v->payment_type == 'card'){
                    $card += $v->amount;
                }elseif($v->type == 'payment' && $v->amount == 0){
                    $discount += $v->discount;
                }elseif($v->type == 'return' && $v->amount > 0){
                    $return += $v->amount;
                }                
            }
            $array[$key]['cash'] = (int) $cash;
            $array[$key]['card'] = (int) $card;
            $array[$key]['return'] = (int) $return;
            $array[$key]['discount'] = (int) $discount;
        }
        return $array;
    }

    public function oylikPayment(){
        $getLast6Months = $this->getLast6Months();
        $array = [];
        foreach ($getLast6Months as $key => $value) {
            $start = $value."-01 00:00:00";
            $end = $value."-31 23:59:59";
            $users = UserPayment::whereBetween('created_at', [$start, $end])->get();
            $cash = 0;
            $card = 0;
            $return = 0;
            $discount = 0;
            foreach ($users as $v) {
                if($v->type == 'payment' && $v->amount > 0 && $v->payment_type == 'cash'){
                    $cash += $v->amount;
                }elseif($v->type == 'payment' && $v->amount > 0 && $v->payment_type == 'card'){
                    $card += $v->amount;
                }elseif($v->type == 'payment' && $v->amount == 0){
                    $discount += $v->discount;
                }elseif($v->type == 'return' && $v->amount > 0){
                    $return += $v->amount;
                }                
            }
            $balanceHistory = BalansHistory::whereBetween('created_at', [$start, $end])->get();
            $exson = 0;
            $xarajat = 0;
            $ishHaqqi = 0;
            $daromad = 0;
            foreach ($balanceHistory as $key => $value) { 
                if($value->type=='chiqim_exson_cash' || $value->type=='chiqim_exson_card'){ 
                    $exson += $value->amount;
                }elseif($value->type=='xarajat_kassa_cash' || $value->type=='xarajat_kassa_card' || $value->type=='xarajat_balans_cash' || $value->type=='xarajat_balans_card'){
                    $xarajat += $value->amount;
                }elseif($value->type=='ishhaqi_pay_cash' || $value->type=='ishhaqi_pay_card'){
                    $ishHaqqi += $value->amount;
                }elseif($value->type=='chiqim_cash' || $value->type=='chiqim_card'){
                    $daromad += $value->amount;
                }
            }
            $array[$key]['cash'] = (int) $cash;
            $array[$key]['card'] = (int) $card;
            $array[$key]['return'] = (int) $return;
            $array[$key]['discount'] = (int) $discount;
            $array[$key]['exson'] = (int) $exson;
            $array[$key]['xarajat'] = (int) $xarajat;
            $array[$key]['ishHaqqi'] = (int) $ishHaqqi;
            $array[$key]['daromad'] = (int) $daromad;
        }
        return $array;
    }

    public function payment(){
        $getLast5Weeks = $this->getLast5Weeks();
        $haftalikPayment = $this->haftalikPayment();
        $getLast7Days = $this->getLast7Days();
        $kunlikPayment = $this->kunlikPayment();
        $getLast6Months = $this->getLast6Months();
        $oylikPayment = $this->oylikPayment();        
        return view('chart.payment', compact('getLast5Weeks', 'haftalikPayment','getLast7Days', 'kunlikPayment','getLast6Months','oylikPayment'));    
    }

}
