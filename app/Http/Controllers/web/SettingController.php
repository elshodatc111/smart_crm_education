<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\web\SettingCreateRegionRequest;
use App\Models\Classroom;
use App\Models\Cours;
use App\Models\CoursAudio;
use App\Models\CoursBook;
use App\Models\CoursTest;
use App\Models\CoursVideo;
use App\Models\SettingRegion;
use App\Models\SettingSms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SettingController extends Controller{

    public function payment(){
        return view('setting.payment');
    }

    public function coursRoom(){
        $cours = Cours::withCount([
            'videos',
            'audios',
            'tests',
            'books'
        ])->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'cours_name' => $item->cours_name,
                'cours_type' => $item->cours_type == 'free' ? 'Bepul kurs' : 'Maxsus kurs',
                'video' => $item->videos_count,
                'audio' => $item->audios_count,
                'test' => $item->tests_count,
                'book' => $item->books_count,
            ];
        });
        $classrooms = Classroom::all();
        return view('setting.cours', compact('cours','classrooms'));
    }
    public function coursShow($id){
        return view('setting.cours_show');
    }
    public function storeCours(Request $request){
        $request->validate([
            'cours_name' => 'required|string|max:255',
            'cours_type' => 'required|in:free,premium',
            'description' => 'required|string|max:500'
        ]);
        Cours::create([
            'cours_name' => $request->cours_name,
            'cours_type' => $request->cours_type,
            'description' => $request->description
        ]);
        return back()->with('success','Kurs muvaffaqiyatli qo\'shildi');
    }
    public function destroyRoom($id){
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();
        return redirect()->back()->with('success','Xona muvaffaqiyatli o\'chirildi');
    }
    public function storeRoom(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'sigim' => 'required|integer|min:1',
            'qavat' => 'required|integer|min:0',
            'description' => 'nullable|string|max:500',
        ]);
        Classroom::create([
            'name' => $request->name,
            'sigim' => $request->sigim,
            'qavat' => $request->qavat,
            'description' => $request->description
        ]);
        return back()->with('success','Xona muvaffaqiyatli qo\'shildi');
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
