<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use App\Models\UserPayment;
use Illuminate\Http\Request;
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
        foreach ($getLast12Months as $key => $value) {
            $Groups = Group::where('start_lesson','>=',$value.'-01')->where('start_lesson','<=',$value.'-31')->get();
            $userid = [];
            foreach ($Groups as $k => $v) {
                $groupUsers = GroupUser::where('group_id',$v->id)->get();
                foreach ($groupUsers as $key => $value2) {
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

    public function payment(){
         return view('chart.payment');    
    }

}
