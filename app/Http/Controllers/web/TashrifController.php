<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Visit\ChangeUserStatusRequest;
use App\Http\Requests\Web\Visit\GroupUserStoreRequest;
use App\Http\Requests\Web\Visit\StoreVisitRequest;
use App\Http\Requests\Web\Visit\UpdateUserRequest;
use App\Http\Requests\Web\Visit\UserPaymentStoreRequest;
use App\Models\ChegirmaHistory;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\Kassa;
use App\Models\Note;
use App\Models\PaymentSetting;
use App\Models\User;
use App\Models\UserHistory;
use App\Models\UserPayment;
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
        $now = now()->toDateString();
        $payChegirma = ChegirmaHistory::where('user_id', $id)->whereDate('end_data', '>=', $now)->where('status', 'pending')->orderBy('end_data', 'asc')->get();
        $payChegirmaCanceled = ChegirmaHistory::where('user_id', $id)->whereDate('end_data', '<', $now)->where('status', 'pending')->get();
        foreach ($payChegirmaCanceled as $key => $value) {
            $check = ChegirmaHistory::find($value->id);
            $check->status == 'cancel';
            $check->save();
        }
        $groups = GroupUser::where('user_id',$id)->get();
        $resGroup = [];
        $resGroup['active'] = [];
        $resGroup['all'] = [];
        foreach ($groups as $key => $value) {
            if($value->is_active){
                $resGroup['active'][$key]['id'] = $value->id;
                $resGroup['active'][$key]['group_id'] = $value->group_id;
                $resGroup['active'][$key]['group'] = $value->group->group_name;
            }
            $resGroup['all'][$key]['id'] = $value->id;
            $resGroup['all'][$key]['group_id'] = $value->group_id;
            $resGroup['all'][$key]['group'] = $value->group->group_name;
            $resGroup['all'][$key]['is_active'] = $value->is_active;
            $resGroup['all'][$key]['start_data'] = $value->start_data->format('Y-m-d');
            $resGroup['all'][$key]['start_comment'] = $value->start_comment;
            $resGroup['all'][$key]['start_admin'] = $value->startAdmin->name;
            $resGroup['all'][$key]['end_data'] = $value->end_data?$value->end_data->format('Y-m-d'):"";
            $resGroup['all'][$key]['end_comment'] = $value->end_comment?$value->end_comment:"";
            $resGroup['all'][$key]['end_admin'] = $value->end_admin_id?$value->endAdmin->name:"";
        }
        $UserPayment = UserPayment::where('user_id',$id)->get();
        $user_payments = [];
        foreach ($UserPayment as $key => $value) {
            if($value->amount == 0){
                $type = "Chegirma";
            }else{
                $type = $value->type;
            }
            $user_payments[$key]['group'] = $value->group?$value->group->group_name:"-";
            $user_payments[$key]['type'] = $type;
            $user_payments[$key]['amount'] = $value->amount;
            $user_payments[$key]['discount'] = $value->discount;
            $user_payments[$key]['payment_type'] = $value->amount == 0?'chegirma':$value->payment_type;
            $user_payments[$key]['description'] = $value->description;
            $user_payments[$key]['admin'] = $value->admin->name;
            $user_payments[$key]['created_at'] = $value->created_at;
        }
        return view('tashrif.tashrif_show',compact('user','notes','history','newGroups','payChegirma','resGroup','user_payments'));
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

    public function addPayment(UserPaymentStoreRequest $request){
         DB::transaction(function () use ($request) {
            $kassa = Kassa::first();            
            $pay = $request->cash + $request->card;
            $group_id = null;            
            $user = User::findOrFail($request->user_id);
            if($request->type == 'payment'){
                $now = now()->toDateString();
                $payChegirma = ChegirmaHistory::where('user_id', $request->user_id)->whereDate('end_data', '>=', $now)->where('status', 'pending')->where('amount',$pay)->orderBy('end_data', 'asc')->first();
                if($payChegirma){
                    $discount = $payChegirma->discount;
                    $payChegirma->status = 'success';
                    $payChegirma->save();
                    $group = $payChegirma->group->group_name ?? 'Noma’lum guruh';
                    $group_id = $payChegirma->group_id;
                    UserPayment::create([
                        'user_id' => $request->user_id,
                        'type' => 'payment',
                        'group_id' => $group_id,
                        'amount' => 0,
                        'discount' => $discount,
                        'payment_type' => 'cash',
                        'status' => 'success',
                        'description' => $group." guruhga ".$pay." to'lovi uchun ".$discount." chegirma berildi",
                        'admin_id' => Auth::id(),
                    ]);
                    UserHistory::create([
                        'user_id' => $request->user_id,
                        'type' => 'discont',
                        'description' => $group." guruhga ".$pay." to'lovi uchun ".$discount." chegirma berildi",
                        'created_by' => Auth::id()
                    ]);
                    
                    $user->increment('balance', $discount);
                }
            }
            if($request->cash>0){
                UserPayment::create([
                    'user_id' => $request->user_id,
                    'group_id' => $group_id,
                    'type' => $request->type,
                    'amount' => $request->cash,
                    'discount' => 0,
                    'payment_type' => 'cash',
                    'status' => 'success',
                    'description' => $request->description,
                    'admin_id' => Auth::id(),
                ]);
                if($request->type == 'payment'){
                    $kassa->increment('cash', $request->cash);
                    UserHistory::create([
                        'user_id' => $request->user_id,
                        'type' => 'payment_cash',
                        'description' => $request->cash.' naqt to\'lov qildi',
                        'created_by' => Auth::id()
                    ]);
                }else{
                    $kassa->decrement('cash', $request->cash);
                    UserHistory::create([
                        'user_id' => $request->user_id,
                        'type' => 'payment_return',
                        'description' => $request->cash.' naqt to\'lov qaytarildi',
                        'created_by' => Auth::id()
                    ]);
                }
                
            }
            if($request->card>0){
                UserPayment::create([
                    'user_id' => $request->user_id,
                    'group_id' => $group_id,
                    'type' => $request->type,
                    'amount' => $request->card,
                    'discount' => 0,
                    'payment_type' => 'card',
                    'status' => 'success',
                    'description' => $request->description,
                    'admin_id' => Auth::id(),
                ]);
                if($request->type == 'payment'){
                    $kassa->increment('card', $request->card);
                    UserHistory::create([
                        'user_id' => $request->user_id,
                        'type' => 'payment_card',
                        'description' => $request->card." karta to'lov qildi",
                        'created_by' => Auth::id()
                    ]);
                }else{
                    $kassa->decrement('card', $request->card);
                    UserHistory::create([
                        'user_id' => $request->user_id,
                        'type' => 'payment_return',
                        'description' => $request->card." karta to'lov qaytarildi",
                        'created_by' => Auth::id()
                    ]);
                }
            }
            if($request->type == 'payment'){
                $user->increment('balance', $pay);
            }else{
                $user->decrement('balance', $pay);
            }
         });
         return back()->with('success', 'To\'lov mofaqiyatli amalga oshirildi');
    }


}
