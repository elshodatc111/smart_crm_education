<?php

namespace App\Http\Controllers\api\teacher;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupData;
use App\Models\GroupUser;
use App\Models\UserDavomad;
use App\Services\api\TeacherService;
use Illuminate\Http\JsonResponse;

class TeacherGroupsController extends Controller{
    
    protected TeacherService $teacherService;
    public function __construct(TeacherService $teacherService){
        $this->teacherService = $teacherService;
    }
    public function home(): JsonResponse{
        $res = $this->teacherService->getGroupsForTeacher(auth()->id());
        return response()->json([
            'status' => 'success',
            'data'   => $res
        ],200);
    }

    public function homeShow($id):JsonResponse{
        $data = $this->teacherService->getGroupDetails((int)$id);
        return response()->json([
            'status' => 'success',
            'data'   => $data
        ],200);
    }

    public function homeShowUsers($id):JsonResponse{
        $data = $this->teacherService->getGroupUsersWithAttendance((int)$id);
        return response()->json([
            'status' => 'success',
            'data'   => $data
        ],200);
    }

    public function HomeShowData($id):jsonResponse{
        $res = $this->teacherService->getGroupDates((int)$id);
        return response()->json([
            'status' => 'success',
            'data'   => $res
        ],200);
    }

}
