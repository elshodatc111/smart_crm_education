<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\api\user\UserGroupController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Emploes\StoreEmploesRequest;
use App\Http\Requests\Web\Emploes\UpdateUserRequest;
use App\Models\EmplesPayment;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use App\Models\UserDavomad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EmploesController extends Controller{
    
    public function emploes(){
        $users = User::where('role','!=','admin')->where('role','!=','user')->get();
        return view('emploes.emploes',compact('users'));
    }

    public function store(StoreEmploesRequest $request){
        User::create([
            'name' => $request->name,
            'role' => $request->role,
            'phone' => $request->phone,
            'phone_alt' => $request->phone_alt,
            'balance' => $request->balance,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'created_by' => Auth::id(),
            'password' => 'password'
        ]);
        return back()->with('success', 'Hodim muvaffaqiyatli qo‘shildi');
    }
    // O'qituvchi ish haqini hisoblash
    public function getTeacherSalaryReport($teacherId){
        $thresholdDate = now()->subDays(40)->format('Y-m-d');
        $today = now()->format('Y-m-d');
        $groups = Group::with(['students' => function($q) {
                $q->where('is_active', true);
            }])->where('teacher_id', $teacherId)->where(function($query) use ($thresholdDate) {
                $query->where('end_lesson', '>=', $thresholdDate)->orWhereNull('end_lesson');
            })->orderBy('end_lesson', 'asc')->get();
        $res = [];
        foreach ($groups as $group) {
            $paidAmount = EmplesPayment::where('group_id', $group->id)->where('user_id', $teacherId)->sum('amount');
            $lessonDaysCount = UserDavomad::where('group_id', $group->id)->distinct('date')->count('date');
            $activeStudents = $group->students;
            $usersCount = $activeStudents->count();
            $bonusCount = 0;
            $status = 'jarayonda';
            $startLesson = $group->start_lesson?->format('Y-m-d');
            $endLesson = $group->end_lesson;
            if ($startLesson && $startLesson > $today) {
                $status = 'yangi';
            } elseif ($endLesson && $endLesson < $today) {
                $status = 'yakunlangan';
            }
            foreach ($activeStudents as $student) {
                if ($group->end_lesson) {
                    $hasBonus = GroupUser::where('user_id', $student->user_id)->where('group_id', '!=', $group->id)->where('is_active', true)->where('start_data', '>=', $group->end_lesson)->exists();
                    if ($hasBonus) {
                        $bonusCount++;
                    }
                }
            }
            $calculatedSalary = ($group->teacher_pay * $usersCount) + ($group->teacher_bonus * $bonusCount);
            $res[] = [
                'group_id'        => $group->id,
                'group_name'      => $group->group_name,
                'status'          => $status,
                'start_lesson'    => $startLesson,
                'end_lesson'      => $endLesson,
                'dars_count'        => $group->lesson_count,
                'davomat_count'     => $lessonDaysCount,
                'teacher_pay'     => (int) $group->teacher_pay,
                'teacher_bonus'   => (int) $group->teacher_bonus,
                'users'           => $usersCount,
                'users_bonus'     => $bonusCount,
                'payment'         => (int) $paidAmount,
                'payment_hisob'   => (int) $calculatedSalary,
                'payment_qoldiq'  => (int) ($calculatedSalary - $paidAmount),
            ];
        }
        return $res;
    }

    public function emploesShow($id){
        $user = User::findOrFail($id); 
        $teacherGroups = $this->getTeacherSalaryReport($id);
        return view('emploes.emploes_show',compact('user','teacherGroups'));
    }

    public function updatePassword(Request $request){
        $user = User::findOrFail($request->user_id);
        $user->password = 'password';
        $user->save();
        return back()->with('success', 'Parol yangilandi!');
    }

    public function toggleStatus(Request $request){
        $user = User::findOrFail($request->user_id);
        $user->is_active = !$user->is_active; 
        $user->save();
        return back()->with('success', 'Foydalanuvchi holati o‘zgartirildi!');
    }

    public function update(UpdateUserRequest $request){
        $user = User::findOrFail($request->user_id);
        $user->update([
            'name'       => $request->name,
            'birth_date' => $request->birth_date,
            'role'       => $request->role,
            'phone'      => $request->phone,
            'phone_alt'  => $request->phone_alt,
        ]);
        return redirect()->back()->with('success', 'Foydalanuvchi muvaffaqiyatli yangilandi!');
    }


}
