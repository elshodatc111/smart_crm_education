<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\CoursAudio;
use App\Models\CoursBook;
use App\Models\CoursVideo;
use App\Models\Group;
use App\Models\GroupUser;
use App\Services\api\UserGroupsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class UserGroupController extends Controller{

    protected $userGroupsService;

    public function __construct(UserGroupsService $service){
        $this->userGroupsService = $service;
    }

    public function home(): JsonResponse{
        try {
            $courses = $this->userGroupsService->getAvailableCourses(Auth::id());
            return response()->json([
                'status' => 'success',
                'data'   => $courses
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kurslarni yuklashda xatolik: ' . $e->getMessage()
            ], 500);
        }
    }

    public function video($id){
        $videos = $this->userGroupsService->getCourseVideos((int)$id);
        return response()->json(['status' => 'success', 'data' => $videos],200);
    }

    public function audio($id){
        $audios = $this->userGroupsService->getCourseAudios((int)$id);
        return response()->json(['status' => 'success', 'data' => $audios],200);
    }

    public function book($id){
        $books = $this->userGroupsService->getCourseBooks((int)$id);
        return response()->json(['status' => 'success', 'data' => $books],200);
    }

}
