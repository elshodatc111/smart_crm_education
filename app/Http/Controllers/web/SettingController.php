<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\web\SettingCreateRegionRequest;
use App\Models\SettingRegion;
use App\Models\SettingSms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SettingController extends Controller{

    public function payment(){
        return view('setting.payment');
    }

    public function cours(){
        return view('setting.cours');
    }

    public function region(){
        $regions = SettingRegion::get();
        $setting = SettingSms::firstOrCreate(
            [],
            [
                'visit_sms' => false,
                'payment_sms' => false,
                'password_sms' => false,
                'birthday_sms' => false,
            ]
        );
        return view('setting.region',compact('regions','setting'));
    }
    public function createRegion(SettingCreateRegionRequest $request){
        SettingRegion::create([
            ...$request->validated(),
            'created_by' => Auth::id()
        ]);
        return back()->with('success','Hudud muvaffaqiyatli qo‘shildi');
    }
    public function destroyRegion($id){
        $region = SettingRegion::findOrFail($id);
        $region->deleted_by = Auth::id();
        $region->save();
        $region->delete();
        return back()->with('success','Hudud muvaffaqiyatli o‘chirildi');
    }
    public function smsUpdate(Request $request){
        SettingSms::updateOrCreate(
            ['id' => 1],
            [
                'visit_sms' => $request->has('visit_sms'),
                'payment_sms' => $request->has('payment_sms'),
                'password_sms' => $request->has('password_sms'),
                'birthday_sms' => $request->has('birthday_sms'),
            ]
        );
        return back()->with('success', 'SMS sozlamalar yangilandi');
    }







}
