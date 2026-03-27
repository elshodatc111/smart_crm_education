<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\user\TestAnswerStoreRequest;
use App\Models\CoursTest;
use App\Models\Group;
use App\Models\GroupTest;
use App\Models\GroupUser;
use App\Services\api\UserGroupsService;
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

    public function allGroups():JsonResponse{
        try {
            $groups = $this->userGroupsService->getUserGroups(auth()->id());
            return response()->json([
                'status' => 'success',
                'data'   => $groups
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Guruhlarni yuklashda xatolik yuz berdi.'
            ], 500);
        }
    }

    public function groupsShow($id){
        try {
            $data = $this->userGroupsService->getStudentGroupDetails((int)$id);
            return response()->json([
                'status' => 'success',
                'data'   => $data
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Guruh topilmadi.'
            ], 44);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Xatolik yuz berdi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function payments():JsonResponse{
        try {
            $res = $this->userGroupsService->getUserPaymentHistory(auth()->id());
            return response()->json([
                'status' => 'success',
                'data'   => $res
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'To‘lovlar tarixini yuklashda xatolik yuz berdi.'
            ], 500);
        }
    }

    public function testGroup():JsonResponse{
        $data = $this->userGroupsService->getUserGroupTests();        
        return response()->json($data);
    }

    public function testShow($cours_id, $group_id): JsonResponse{
        $data = $this->userGroupsService->getCourseTests((int)$cours_id, (int)$group_id);
        return response()->json($data);
    }
    
    public function testStore(TestAnswerStoreRequest $request): JsonResponse{
        try {
            $result = $this->userGroupsService->storeTestResult($request->validated());
            return response()->json([
                'status'  => 'success',
                'message' => 'Test natijalari saqlandi',
                'data'    => [
                    'total'   => $result->savollar,
                    'correct' => $result->togri_javob,
                    'ball'    => $result->ball,
                ]
            ], 200);            
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Xatolik yuz berdi: ' . $e->getMessage()
            ], 500);
        }
    }


}
