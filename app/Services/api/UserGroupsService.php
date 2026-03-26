<?php

namespace App\Services\api;

use App\Models\Cours;
use App\Models\CoursAudio;
use App\Models\CoursBook;
use App\Models\CoursVideo;
use App\Models\Group;
use App\Models\GroupData;
use App\Models\GroupUser;
use App\Models\UserDavomad;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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
        return CoursBook::where('cours_id', $courseId)->select('id', 'book_name', 'book_url', 'description')->get();}


}