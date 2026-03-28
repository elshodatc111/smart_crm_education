<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupData;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller{
    public function getCurrentWeekDays(){
        $days = [];
        $monday = Carbon::now()->startOfWeek(Carbon::MONDAY);
        for ($i = 0; $i < 6; $i++) {
            $days[] = $monday->copy()->addDays($i)->format('Y-m-d');
        }
        return $days;
    }

    public function darsJadvali(){
        $vaqtlar = [
            '08:00 - 09:30',
            '09:30 - 11:00',
            '11:00 - 12:30',
            '12:30 - 14:00',
            '14:00 - 15:30',
            '15:30 - 17:00',
            '17:00 - 18:30',
            '18:30 - 20:00',
            '20:00 - 21:30',
        ];
        $kunlar = $this->getCurrentWeekDays();
        $array = [];
        foreach ($vaqtlar as $key1 => $value1) {
            $array[$key1]['vaqt'] = $value1;
            foreach ($kunlar as $key2 => $value2) { 
                $array[$key1][$key2]['kun'] = $value2;
                $GroupData = GroupData::where('data', $value2)->where('time', $value1)->get();
                $i = 0;
                $gg = [];
                foreach ($GroupData as $group) {
                    $gg[$i]['group_id'] = $group->group_id;
                    $GROUP = Group::find($group->group_id);
                    $gg[$i]['group_name'] = $GROUP->group_name;
                    $gg[$i]['teacher'] = $GROUP->teacher->name;
                    $i++;
                }
                $array[$key1][$key2]['guruh'] = $gg;
            }
        }
        return $array;
    }

    public function dashboard(){
        $darsJadvali = $this->darsJadvali();
        return view('index',compact('darsJadvali'));
    }

}
