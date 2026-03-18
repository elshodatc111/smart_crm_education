<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Group\GroupStoreRequest;
use App\Models\Classroom;
use App\Models\Cours;
use App\Models\DamOlishKuni;
use App\Models\Group;
use App\Models\GroupData;
use App\Models\GroupUser;
use App\Models\PaymentSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GroupController extends Controller{

    public function groups(){
        $form = [];
        $form['cours'] = Cours::where('cours_type','premium')->orderby('cours_name','asc')->get();
        $form['rooms'] = Classroom::get();
        $form['paymarts'] = PaymentSetting::where('discount_day','!=','99999')->get();
        $form['teachers'] = User::where('role','teacher')->where('is_active',true)->get();
        
        $groups = Group::with(['teacher'])->withCount([
        'students as users_count' => function ($q) {
            $q->whereNull('end_data');}])->withMax('lessons', 'data')->get()
            ->map(function ($group) {
                $today = now();
                if ($group->start_lesson > $today) {
                    $group->status = 'Yangi';
                    $group->status_order = 1;
                }
                elseif ($group->lessons_max_data && $group->lessons_max_data >= $today) {
                    $group->status = 'Jarayonda';
                    $group->status_order = 2;
                }
                else {
                    $group->status = 'Yakunlangan';
                    $group->status_order = 3;
                }
                return $group;
            })->filter(function ($group) {
                if ($group->status !== 'Yakunlangan') {
                    return true;
                }
            return Carbon::parse($group->lessons_max_data)->gte(now()->subDays(60));
        })->sortBy([
            ['status_order', 'asc'],
            ['lesson_time', 'desc'],
        ])->map(function ($group) {
            return [
                'id' => $group->id,
                'group_name' => $group->group_name,
                'start_lesson' => $group->start_lesson->format('Y-m-d') . " ( " . $group->lesson_time . " )",
                'teacher' => $group->teacher->name ?? '',
                'users' => $group->users_count,
                'status' => $group->status,
            ];
        })->values();
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
        });
        return back()->with('success', 'Guruh va dars jadvali yaratildi ✅');
    }

    public function show($id){
        return view('group.show');
    }

}
