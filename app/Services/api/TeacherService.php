<?php

namespace App\Services\api;

use App\Models\Group;
use App\Models\GroupData;
use App\Models\GroupUser;
use App\Models\UserDavomad;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TeacherService{ 
    
    public function getGroupsForTeacher($teacherId): Collection{
        $groups = Group::where('teacher_id', $teacherId)->orderBy('start_lesson', 'desc')->get();
        return $groups->map(function ($group) {
            return $this->formatGroupData($group);
        });
    }
    
    private function formatGroupData($group): array{
        $now = now()->startOfDay();
        $start = Carbon::parse($group->start_lesson)->startOfDay();
        $end = Carbon::parse($group->end_lesson)->startOfDay();
        if ($now->lt($start)) {
            $status = "New";
        } elseif ($now->between($start, $end)) {
            $status = "Active";
        } else {
            $status = "End";
        }
        return [
            'id'           => $group->id,
            'group_name'   => $group->group_name,
            'group_type'   => match($group->group_type) {
                'toq'   => "Toq kunlar",
                'juft'  => "Juft kunlar",
                default => "Har kuni",
            },
            'lesson_time'  => $group->lesson_time,
            'start_lesson' => $start->format('Y-m-d'),
            'end_lesson'   => $end->format('Y-m-d'),
            'status'       => $status,
        ];
    }


    public function getGroupDetails(int $id): array{
        $group = Group::with(['course', 'room', 'teacher', 'payment', 'admin'])->findOrFail($id);
        $today = now()->format('Y-m-d');
        $status = GroupData::where('group_id', $id)->where('data', $today)->exists();
        return [
            "id"            => $group->id,
            "cours"         => $group->course?->cours_name ?? 'Noma’lum',
            "room"          => $group->room?->name ?? 'Xona tayinlanmagan',
            "teacher"       => $group->teacher?->name ?? 'O‘qituvchi tayinlanmagan',
            "payment"       => (int) (($group->payment?->payment ?? 0) + ($group->payment?->discount ?? 0)),
            "group_name"    => $group->group_name,
            "lesson_count"  => (int) $group->lesson_count,
            "group_type"    => match($group->group_type) {
                'toq'   => "Toq kunlar",
                'juft'  => "Juft kunlar",
                default => "Har kuni",
            },
            "lesson_time"   => (int) $group->lesson_time,
            "teacher_pay"   => (int) $group->teacher_pay,
            "teacher_bonus" => (int) $group->teacher_bonus,
            "start_lesson"  => $group->start_lesson ? $group->start_lesson->format("Y-m-d") : null,
            "end_lesson"    => $group->end_lesson,
            "admin"         => $group->admin?->name ?? 'Admin biriktirilmagan',
            'darskuni' => $status,
        ];
    }

    public function getGroupUsersWithAttendance(int $groupId): array{
        $today = now()->format('Y-m-d');
        $groupUsers = GroupUser::with(['user'])->where('group_id', $groupId)->where('is_active', true)->get();
        $attendances = UserDavomad::where('group_id', $groupId)->where('date', $today)->pluck('status', 'user_id');
        return $groupUsers->map(function ($item) use ($attendances) {
            return [
                'user_id'    => $item->user_id,
                'user_name'  => $item->user?->name ?? 'Noma’lum',
                'phone'      => $item->user?->phone ?? '',
                'balance'    => (int) ($item->user?->balance ?? 0),
                'start_date' => $item->start_data ? $item->start_data->format("Y-m-d") : null,
                'davomad'    => $attendances[$item->user_id] ?? 'new',
            ];
        })->toArray();
    }

    public function getGroupDates(int $groupId): array{
        $groupData = GroupData::where('group_id', $groupId)->orderBy('data', 'asc')->get();
        $today = now()->startOfDay();
        return $groupData->map(function ($item) use ($today) {
            $lessonDate = Carbon::parse($item->data)->startOfDay();
            if ($lessonDate->gt($today)) {
                $status = 'pending';
            } elseif ($lessonDate->eq($today)) {
                $status = 'Aktiv';
            } else {
                $status = 'End';
            }
            return [
                'id'     => $item->id,
                'date'   => $item->data->format('Y-m-d'),
                'status' => $status
            ];
        })->toArray();
    }

    public function storeAttendance(array $data): void{
        DB::transaction(function () use ($data) {
            $groupId = $data['group_id'];
            $today = now()->toDateString();
            foreach ($data['attendances'] as $attendance) {
                UserDavomad::updateOrCreate(
                    [
                        'group_id' => $groupId,
                        'user_id'  => $attendance['user_id'],
                        'date'     => $today,
                    ],
                    [
                        'status'     => $attendance['status'],
                        'created_by' => Auth::id(),
                    ]
                );
            }
        });
    }

    public function getGroupAttendanceHistory(int $groupId): array{
        $today = now()->format('Y-m-d');
        $users = \App\Models\GroupUser::with('user')->where('group_id', $groupId)->where('is_active', true)->get();
        $groupDates = \App\Models\GroupData::where('group_id', $groupId)->where('data', '<=', $today)->orderBy('data', 'desc')->get();
        $allAttendances = \App\Models\UserDavomad::where('group_id', $groupId)->where('date', '<=', $today)->get()->groupBy('user_id');
        return $users->map(function ($item) use ($groupDates, $allAttendances) {
            $userAttendances = $allAttendances->get($item->user_id) ?? collect();            
            $presents = $userAttendances->where('status', 'keldi')->count();
            $absents = $userAttendances->where('status', 'kelmadi')->count();
            $totalLessons = $groupDates->count();
            return [
                'user_id'   => $item->user_id,
                'user_name' => $item->user?->name ?? 'Noma’lum',
                'stats'     => "($presents/$absents/$totalLessons)",
                'history'   => $groupDates->map(function ($date) use ($userAttendances) {
                    $attendance = $userAttendances->where('date', $date->data)->first();                    
                    return [
                        'date'   => Carbon::parse($date->data)->format('Y-m-d'),
                        'status' => $attendance ? $attendance->status : 'no_data',
                    ];
                }),
            ];
        })->toArray();
    }


}