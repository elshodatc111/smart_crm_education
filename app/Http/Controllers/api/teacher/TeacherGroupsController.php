<?php

namespace App\Http\Controllers\api\teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Group\AttendanceStoreRequest;
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

    public function davomad(AttendanceStoreRequest $request): JsonResponse{
        try {
            $this->teacherService->storeAttendance($request->validated());
            return response()->json([
                'status' => 'success',
                'message' => 'Davomad muvaffaqiyatli saqlandi!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Xatolik yuz berdi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function attendanceHistory($id):JsonResponse{
        $data = $this->teacherService->getGroupAttendanceHistory((int)$id);
        return response()->json([
            'status' => 'success',
            'data'   => $data
        ]);
    }

    public function testNatija($id){
        return response()->json([
            'status' => 'success',
            'data'   => $id,
            'message' => 'Bu qismi tayyorlanmoqda (test natijalari)'
        ]);
    }

}
