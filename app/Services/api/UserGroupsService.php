<?php

namespace App\Services\api;

use App\Models\Cours;
use App\Models\CoursAudio;
use App\Models\CoursBook;
use App\Models\CoursTest;
use App\Models\CoursVideo;
use App\Models\Group;
use App\Models\GroupData;
use App\Models\GroupTest;
use App\Models\GroupUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class UserGroupsService{
    public function getAvailableCourses($userId){
        $myCourseIds = GroupUser::where('user_id', $userId)->where('is_active', true)->with('group')->get()->pluck('group.cours_id')->unique()->toArray();
        $allCourses = Cours::all();
        return $allCourses->filter(function ($course) use ($myCourseIds) {
            return $course->cours_type === 'free' || in_array($course->id, $myCourseIds);
        })->map(function ($course) {
            return [
                'cours_id'    => $course->id,
                'cours_name'  => $course->cours_name,
                'cours_type'  => $course->cours_type,
                'description' => $course->description,
            ];
        })->values();
    }

    public function getCourseVideos(int $courseId){
        return CoursVideo::where('cours_id', $courseId)->orderBy('sort_order', 'asc')->select('id', 'video_name', 'video_url', 'description', 'sort_order')->get();
    }

    public function getCourseAudios(int $courseId){
        return CoursAudio::where('cours_id', $courseId)->orderBy('sort_order', 'asc')->select('id', 'audio_name', 'audio_url', 'description', 'sort_order')->get();
    }

    public function getCourseBooks(int $courseId){
        return CoursBook::where('cours_id', $courseId)->select('id', 'book_name', 'book_url', 'description')->get();
    }

    public function getUserGroups(int $userId): array{
        $groupUsers = GroupUser::with('group')->where('user_id', $userId)->where('is_active', true)->get();
        return $groupUsers->map(function ($item) {
            return [
                'group_id'     => $item->group_id,
                'group_name'   => $item->group?->group_name ?? 'Noma’lum',
                'start_lesson' => $item->group?->start_lesson ? Carbon::parse($item->group->start_lesson)->format('Y-m-d') : null,
                'end_lesson'   => $item->group?->end_lesson ? Carbon::parse($item->group->end_lesson)->format('Y-m-d') : null,
            ];
        })->toArray();
    }

    public function getStudentGroupDetails(int $groupId): array{
        $group = Group::with(['room', 'course', 'teacher', 'payment'])->findOrFail($groupId);
        $groupData = GroupData::where('group_id', $groupId)->orderBy('data', 'asc')->get();
        $dates = $groupData->map(function ($item) {
            return Carbon::parse($item->data)->format('Y-m-d');
        });
        return [
            'group' => [
                "id"           => $group->id,
                "room"         => $group->room?->name ?? 'Noma’lum',
                "cours"        => $group->course?->cours_name ?? 'Noma’lum',
                "teacher"      => $group->teacher?->name ?? 'O‘qituvchi tayinlanmagan',
                "payment"      => (int) (($group->payment?->payment ?? 0) + ($group->payment?->discount ?? 0)),
                "group_name"   => $group->group_name,
                "lesson_count" => (int) $group->lesson_count,
                "group_type"   => match($group->group_type) {
                    'toq'   => "Toq kunlar",
                    'juft'  => "Juft kunlar",
                    default => "Har kuni",
                },
                "lesson_time"  => (int) $group->lesson_time,
                "start_lesson" => $group->start_lesson ? Carbon::parse($group->start_lesson)->format("Y-m-d") : null,
                "end_lesson"   => $group->end_lesson ? Carbon::parse($group->end_lesson)->format("Y-m-d") : null,
            ],
            'dates' => $dates
        ];
    }

    public function getUserPaymentHistory(int $userId): array{
        $payments = \App\Models\UserPayment::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        return $payments->map(function ($value) {
            $isDiscount = (int) $value->amount === 0;
            return [
                'id'           => $value->id,
                'type'         => $isDiscount ? 'discount' : ($value->type ?? 'payment'),
                'amount'       => (int) ($isDiscount ? $value->discount : $value->amount),
                'payment_type' => $value->payment_type ?? 'Noma’lum', // Naqd, Karta va h.k.
                'created_at'   => $value->created_at->format("Y-m-d H:i"), // H:i formatida 24 soatlik vaqt chiqadi
            ];
        })->toArray();
    }

    public function getUserGroupTests(): array{
        $userId = Auth::id();
        $userGroups = GroupUser::with(['group' => function($query) {
                $query->withCount('coursTests');
            }])->where('user_id', $userId)->where('is_active', true)->get();
        $res = [];
        foreach ($userGroups as $userGroup) {
            $group = $userGroup->group;            
            if (!$group) continue;
            $testCount = $group->cours_tests_count;
            if ($testCount > 0) {
                $urinishlar = GroupTest::where('group_id', $group->id)->where('cours_id', $group->cours_id)->where('user_id', $userId)->count();
                $res[] = [
                    'group_id'   => $group->id,
                    'group_name' => $group->group_name,
                    'cours_id'   => $group->cours_id,
                    'testCount'  => $testCount,
                    'urinishlar' => $urinishlar,
                ];
            }
        }
        return $res;
    }

    public function getCourseTests(int $courseId, int $groupId): array{
        $tests = CoursTest::where('cours_id', $courseId)->select(['test_quez', 'answer_a', 'answer_b', 'answer_c', 'answer_d', 'correct_answer'])->get();
        return [
            'group_id' => $groupId,
            'cours_id' => $courseId,
            'quez' => count($tests),
            'tests'    => $tests
        ];
    }

    public function storeTestResult(array $data){
        return GroupTest::create([
            'group_id'    => $data['group_id'],
            'cours_id'    => $data['cours_id'],
            'user_id'     => Auth::id(),
            'savollar'    => $data['savollar'],
            'togri_javob' => $data['togri_javob'],
            'ball'        => $data['ball'],
        ]);
    }

}