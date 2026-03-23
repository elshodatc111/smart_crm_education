<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Group\AttendanceStoreRequest;
use App\Http\Requests\Web\Group\GroupStoreRequest;
use App\Http\Requests\Web\Group\RemoveStudentRequest;
use App\Http\Requests\Web\Group\SendDebitSmsRequest;
use App\Http\Requests\Web\Group\StoreGroupContinueRequest;
use App\Http\Requests\Web\Visit\UpdateGroupRequest;
use App\Models\ChegirmaHistory;
use App\Models\Classroom;
use App\Models\Cours;
use App\Models\DamOlishKuni;
use App\Models\Group;
use App\Models\GroupData;
use App\Models\GroupUser;
use App\Models\PaymentSetting;
use App\Models\User;
use App\Models\UserDavomad;
use App\Models\UserHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GroupController extends Controller{

    public function groups(){
        $form = [];
        $form['cours'] = Cours::where('cours_type','premium')->orderby('cours_name','asc')->get();
        $form['rooms'] = Classroom::get();
        $form['paymarts'] = PaymentSetting::where('discount_day','!=','99999')->get();
        $form['teachers'] = User::where('role','teacher')->where('is_active',true)->get();
        $dateEnd = now()->subDays(60);
        $GROUP = Group::where('end_lesson','>=',$dateEnd)->orderBy('start_lesson','desc')->with('teacher')->get();
        $groups = [];
        foreach ($GROUP as $key => $value) {
            $today = now()->toDateString();
            if ($value->start_lesson > $today) {
                $status = 'Yangi';
            } elseif ($value->start_lesson <= $today && $value->end_lesson >= $today) {
                $status = 'Jarayonda';
            } else {
                $status = 'Yakunlangan';
            }
            $groups[$key]['id'] = $value->id;
            $groups[$key]['group_name'] = $value->group_name;
            $groups[$key]['end_lesson'] = $value->end_lesson;
            $groups[$key]['start_lesson'] = $value->start_lesson->format('Y-m-d')." (".$value->lesson_time.")";
            $groups[$key]['teacher'] = $value->teacher->name ?? '';
            $groups[$key]['users'] = GroupUser::where('group_id',$value->id)->where('is_active',true)->count();
            $groups[$key]['status'] = $status;
        }
        return view('group.groups',compact('form','groups'));
    }

    public function store(GroupStoreRequest $request){
        DB::transaction(function () use ($request) {
            $group = Group::create([
                'cours_id' => $request->cours_id,
                'room_id' => $request->room_id,
                'teacher_id' => $request->teacher_id,
                'payment_id' => $request->payment_id,
                'group_name' => $request->group_name,
                'lesson_count' => $request->lesson_count,
                'group_type' => $request->group_type,
                'lesson_time' => $request->lesson_time,
                'teacher_pay' => $request->teacher_pay,
                'teacher_bonus' => $request->teacher_bonus,
                'start_lesson' => $request->start_lesson,
                'admin_id' => Auth::id(),
                'next_group_id' => null,
            ]);
            $daysMap = match ($request->group_type) {
                'toq' => [1, 3, 5],
                'juft' => [2, 4, 6],
                'all' => [1, 2, 3, 4, 5, 6],
            };
            $start = Carbon::parse($request->start_lesson);
            $lessonCount = $request->lesson_count;
            $lessons = [];
            $count = 0;
            while ($count < $lessonCount) {
                $isHoliday = DamOlishKuni::whereDate('data', $start)->exists();
                if (in_array($start->dayOfWeekIso, $daysMap) && !$isHoliday) {
                    $lessons[] = [
                        'group_id' => $group->id,
                        'data' => $start->toDateString(),
                        'time' => $request->lesson_time,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $count++;
                }
                $start->addDay();
            }
            GroupData::insert($lessons);
            $lastLesson = end($lessons);
            $group->end_lesson = $lastLesson['data'];
            $group->save();
        });
        return back()->with('success', 'Guruh va dars jadvali yaratildi ✅');
    }
    public function showAttendance($groupId) {
        $groupDays = GroupData::where('group_id', $groupId)->orderBy('data', 'asc')->get();
        $groupUsers = GroupUser::with('user')->where('group_id', $groupId)->get();
        $allAttendances = UserDavomad::where('group_id', $groupId)->get()->keyBy(function($item) {return $item->user_id . '_' . $item->date->format('Y-m-d');});
        return [
            'groupDays' => $groupDays,
            'groupUsers' => $groupUsers,
            'allAttendances' => $allAttendances
        ];
    }
    public function show($id){
        $group = Group::findOrFail($id);
        $cours = Cours::get();
        $rooms = Classroom::get();
        $pay_setting = PaymentSetting::get();
        $teacher = User::where('is_active',true)->where('role','teacher')->get();
        $activUser = GroupUser::where('group_id',$id)->where('is_active',true)->get();
        $debitUser = [];
        $activDavomad = GroupUser::with(['user', 'todayAttendance'])->where('group_id', $id)->where('is_active', true)->get();
        foreach ($activUser as $key => $value) {
            if($value->user->balance<0){
                $debitUser[$key]['user_id'] = $value->user->id;
                $debitUser[$key]['name'] = $value->user->name;
                $debitUser[$key]['balance'] = $value->user->balance;
            }
        }
        $debitUserStatus = count($debitUser);
        $davomadTable = $this->showAttendance($id);
        $userHistory = GroupUser::where('group_id',$id)->get();
        return view('group.show',compact('group','cours','rooms','pay_setting','teacher','activUser','debitUser','debitUserStatus','activDavomad','davomadTable','userHistory'));
    }

    public function debitSendMessage(SendDebitSmsRequest $request){
        $groupId = $request->group_id;
        $selectedStudents = $request->student_ids; // Bu tanlangan user_id larning massivi
        try {
            // SMS yuborish logikasi shu yerda bo'ladi
            // Masalan: foreach ($selectedStudents as $id) { ... }
            return back()->with('success', count($selectedStudents) . " ta talabaga SMS yuborish navbatga qo'yildi.");            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'SMS yuborishda texnik xatolik: ' . $e->getMessage()]);
        }
    }

    public function storeGroupContinue(StoreGroupContinueRequest $request){
        try {
            return DB::transaction(function () use ($request) {
                $newGroup = Group::create([
                    'cours_id'      => $request->cours_id,
                    'room_id'       => $request->room_id,
                    'teacher_id'    => $request->teacher_id,
                    'payment_id'    => $request->payment_id,
                    'group_name'    => $request->group_name,
                    'lesson_count'  => $request->lesson_count,
                    'group_type'    => $request->group_type,
                    'lesson_time'   => $request->lesson_time,
                    'teacher_pay'   => $request->teacher_pay,
                    'teacher_bonus' => $request->teacher_bonus,
                    'start_lesson'  => Carbon::parse($request->start_lesson), // Obyektga aylantiramiz
                    'admin_id'      => Auth::id(),
                    'status'        => 'active',
                ]);
                $daysMap = match ($request->group_type) {'toq'  => [1, 3, 5],'juft' => [2, 4, 6],'all'  => [1, 2, 3, 4, 5, 6],};
                $start = Carbon::parse($request->start_lesson);
                $lessons = [];
                $count = 0;
                while ($count < $request->lesson_count) {
                    $isHoliday = DamOlishKuni::whereDate('data', $start->toDateString())->exists();
                    if (in_array($start->dayOfWeekIso, $daysMap) && !$isHoliday) {
                        $lessons[] = [
                            'group_id'   => $newGroup->id,
                            'data'       => $start->toDateString(),
                            'time'       => $request->lesson_time,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        $count++;
                    }$start->addDay();
                }
                GroupData::insert($lessons);
                $lastLesson = end($lessons);
                $newGroup->end_lesson = $lastLesson['data'];
                $newGroup->save();
                $oldGroup = Group::findOrFail($request->group_id);
                $oldGroup->next_group_id = $newGroup->id;
                $oldGroup->save();
                $paymentSetting = PaymentSetting::findOrFail($newGroup->payment_id);
                $totalDebit = $paymentSetting->payment + $paymentSetting->discount;
                if ($request->has('student_ids') && is_array($request->student_ids)) {
                    foreach ($request->student_ids as $studentId) {
                        $userGroup = GroupUser::create([
                            'group_id'       => $newGroup->id,
                            'user_id'        => $studentId,
                            'is_active'      => true,
                            'start_data'     => now()->format('Y-m-d'),
                            'start_comment'  => "{$oldGroup->group_name} guruhidan davom ettirildi.",
                            'start_admin_id' => Auth::id(),
                        ]);
                        $user = User::findOrFail($studentId);
                        $user->decrement('balance', $totalDebit);
                        UserHistory::create([
                            'user_id'     => $studentId,
                            'type'        => 'group_add',
                            'description' => "{$newGroup->group_name} guruhiga o'tdi. Balansdan {$totalDebit} UZS yechildi.",
                            'created_by'  => Auth::id()
                        ]);
                        if ($paymentSetting->discount > 0) {
                            $discountDays = (int) $paymentSetting->discount_day;
                            $chegirmaDeadline = $newGroup->start_lesson->copy()->addDays($discountDays - 1);
                            if ($chegirmaDeadline->gte(now())) {
                                ChegirmaHistory::create([
                                    'group_id'      => $newGroup->id,
                                    'user_id'       => $studentId,
                                    'group_user_id' => $userGroup->id,
                                    'start_data'    => $newGroup->start_lesson->toDateString(),
                                    'end_data'      => $chegirmaDeadline->toDateString(),
                                    'amount'        => $paymentSetting->payment,
                                    'discount'      => $paymentSetting->discount,
                                    'status'        => 'pending',
                                ]);
                            }
                        }
                    }
                }
                return redirect()->route('group_show', $newGroup->id)->with('success', "Guruh muvaffaqiyatli davom ettirildi!");
            });
        } catch (\Exception $e) {
            Log::error("Guruh ko'chirishda xato: " . $e->getMessage());
            return redirect()->back()->withInput()->with('error', "Xatolik: " . $e->getMessage());
        }
    }

    public function groupUpdate(UpdateGroupRequest $request){
        $group = Group::findOrFail($request->group_id);
        $group->group_name = $request->group_name;
        $group->teacher_id = $request->teacher_id;
        $group->cours_id = $request->cours_id;
        $group->room_id = $request->room_id;
        $group->teacher_pay = $request->teacher_pay;
        $group->teacher_bonus = $request->teacher_bonus;
        $group->save();
        return redirect()->back()->with('success', "Guruh muvaffaqiyatli yangilandi");
    }

    public function remoteUser(RemoveStudentRequest $request){
        return DB::transaction(function () use ($request) {
            $userGroup = GroupUser::where('group_id',$request->group_id)->where('user_id',$request->user_id)->where('is_active',true)->first();
            $userGroup->end_data = now();
            $userGroup->end_comment = $request->description;
            $userGroup->end_admin_id = Auth::id();
            $userGroup->is_active = false;
            $userGroup->save();
            $user = User::findOrFail($request->user_id);
            $user->increment('balance', $request->maxJarima - $request->jarima);
            $ChegirmaHistory = ChegirmaHistory::where('group_id',$request->group_id)->where('user_id',$request->user_id)->where('status','pending')->first();
            if($ChegirmaHistory){
                $ChegirmaHistory->status = 'cancel';
                $ChegirmaHistory->save();
            }
            $group = Group::findOrFail($request->group_id);
            UserHistory::create([
                'user_id'     => $request->user_id,
                'type'        => 'jarima',
                'description' => "{$group->group_name} guruhdan o'chirildi. Balansdan {$request->jarima} UZS ushlab qilindi.",
                'created_by'  => Auth::id()
            ]);
            $repet = $request->maxJarima - $request->jarima;
            UserHistory::create([
                'user_id'     => $request->user_id,
                'type'        => 'group_delete',
                'description' => "{$group->group_name} guruhdan o'chirildi. Balansiga {$repet} UZS qaytarildi",
                'created_by'  => Auth::id()
            ]);
            return redirect()->back()->with('success', "Guruh muvaffaqiyatli o'chirildi!");
        });
    }

    public function davomad(AttendanceStoreRequest $request){
        try {
            DB::transaction(function () use ($request) {
                $groupId = $request->group_id;
                $today = now()->toDateString();
                foreach ($request->attendances as $data) {
                    UserDavomad::updateOrCreate(
                        [
                            'group_id' => $groupId,
                            'user_id'  => $data['user_id'],
                            'date'     => $today,
                        ],
                        [
                            'status'     => $data['status'],
                            'created_by' => Auth::id(),
                        ]
                    );
                }
            });
            return back()->with('success', 'Bugun uchun davomad muvaffaqiyatli saqlandi!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Xatolik: ' . $e->getMessage()]);
        }
    }

}
