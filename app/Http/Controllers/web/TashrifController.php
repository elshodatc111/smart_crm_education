<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Visit\ChangeUserStatusRequest;
use App\Http\Requests\Web\Visit\GroupUserStoreRequest;
use App\Http\Requests\Web\Visit\StoreVisitRequest;
use App\Http\Requests\Web\Visit\UpdateUserRequest;
use App\Models\ChegirmaHistory;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\Note;
use App\Models\PaymentSetting;
use App\Models\User;
use App\Models\UserHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TashrifController extends Controller{



    public function tashriflar(){
        $users = User::where('role','user')->orderby('id','desc')->get();
        return view('tashrif.tashriflar',compact('users'));
    }

    public function store(StoreVisitRequest $request){
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'phone_alt' => $request->phone_alt,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'password' => 'password',
            'role' => 'user',
            'is_active' => true,
            'balance' => 0,
            'created_by' => Auth::id(),
        ]);
        UserHistory::create([
            'user_id' => $user->id,
            'type' => 'visit',
            'description' => "Markazga tashri",
            'created_by' => Auth::id()
        ]);
        return back()->with('success','Tashrif muvaffaqiyatli qo‘shildi');
    }

    protected function newGroups($user_id){
        $today = now()->toDateString();
        $groups = Group::where('end_lesson','>=',$today)->get();
        $res = [];
        foreach ($groups as $key => $value) {
            $check = GroupUser::where('group_id',$value->id)->where('user_id',$user_id)->where('is_active',true)->first();
            if(!$check){
                $res[$key]['group_id'] = $value->id;
                $res[$key]['group_name'] = $value->group_name;
                $res[$key]['teacher'] = $value->teacher->name;
                $res[$key]['start_lesson'] = $value->start_lesson->format("Y-m-d");
                $res[$key]['lesson_time'] = $value->lesson_time;
                $res[$key]['end_lesson'] = $value->end_lesson;
            }
        }
        return $res;
    }

    public function tashrifShow($id){
        $user = User::findOrFail($id);
        $notes = Note::where('note_id',$id)->where('type','user')->orderby('id', 'desc')->get();
        $history = UserHistory::where('user_id',$id)->orderby('id','desc')->get();
        $newGroups = $this->newGroups($id);
        return view('tashrif.tashrif_show',compact('user','notes','history','newGroups'));
    }
    
    public function addGroup(GroupUserStoreRequest $request){
        DB::transaction(function () use ($request) {
            $user_group = GroupUser::create([
                'group_id' => $request->group_id,
                'user_id' => $request->user_id,
                'start_data' => now(),
                'start_comment' => $request->start_comment,
                'start_admin_id' => Auth::id(),
                'is_active' => true,
            ]);
            $group = Group::findOrFail($request->group_id);
            $payment = PaymentSetting::findOrFail($group->payment_id);
            $pay = $payment->payment + $payment->discount;
            $user = User::findOrFail($request->user_id);
            $user->decrement('balance', $pay);
            UserHistory::create([
                'user_id' => $request->user_id,
                'type' => 'group_add',
                'description' => $group->group_name."-guruhga qo'shildi. ".$pay." UZS balansidan yechildi",
                'created_by' => Auth::id()
            ]);
            $chegirmaDay = $payment->discount_day;
            $nextDay = $group->start_lesson->copy()->addDays($chegirmaDay - 1)->toDateString();
            $endDate = $group->start_lesson->copy()->addDays($chegirmaDay - 1);
            if ($endDate->gte(now())) {
                ChegirmaHistory::create([
                    'group_id' => $request->group_id,
                    'user_id' => $request->user_id,
                    'group_user_id' => $user_group->id,
                    'start_data' => $group->start_lesson->format('Y-m-d'),
                    'end_data' => $nextDay,
                    'amount' => $payment->payment,
                    'discount' => $payment->discount,
                    'status' => 'pending',
                ]);
            }
        });
        return back()->with('success', 'Amaliyot muvaffaqiyatli bajarildi ✅');
    }

    public function storeNote(Request $request){
        $request->validate([
            'note_id' => 'required|integer',
            'type' => 'required|in:user,emploes,groups',
            'text' => 'required|string|max:1000',
        ]);
        Note::create([
            'note_id' => $request->note_id,
            'type' => $request->type,
            'text' => $request->text,
            'created_by' => Auth::id(),
        ]);
        return back()->with('success', 'Eslatma qo‘shildi');
    }

    public function changeStatus(ChangeUserStatusRequest $request){
        $user = User::findOrFail($request->user_id);
        UserHistory::create([
            'user_id' => $user->id,
            'type' => $user->is_active?'status_of':'status_on',
            'description' => $user->is_active?"Talaba bloklandi":"Talaba aktivlashtirildi",
            'created_by' => Auth::id()
        ]);
        $user->is_active = !$user->is_active;
        $user->save();
        return back()->with('success', 'Status muvaffaqiyatli o‘zgartirildi');
    }

    public function resetPassword(ChangeUserStatusRequest $request){
        $user = User::findOrFail($request->user_id);
        UserHistory::create([
            'user_id' => $user->id,
            'type' => 'resset_password',
            'description' => 'Talaba paroli yangilandi',
            'created_by' => Auth::id()
        ]);
        $user->password = 'password';
        $user->save();
        return back()->with('success', "Parol yangilandi. Yangi parol: password");
    }
    
    public function update(UpdateUserRequest $request, $id){
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'phone_alt' => $request->phone_alt,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
        ]);
        UserHistory::create([
            'user_id' => $user->id,
            'type' => 'update',
            'description' => 'Talaba malumotlari yangilandi',
            'created_by' => Auth::id()
        ]);
        return back()->with('success', 'Foydalanuvchi ma’lumotlari yangilandi');
    }



}
