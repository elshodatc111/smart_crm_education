<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\auth\ChangePasswordRequest;
use App\Http\Requests\api\auth\LoginRequest;
use App\Services\api\AuthService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller{

    protected AuthService $authService;
    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }

    public function login(LoginRequest $request): JsonResponse{
        $result = $this->authService->login($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Tizimga muvaffaqiyatli kirdingiz',
            'data' => [
                'user' => [
                    'id'      => $result['user']->id,
                    'role'    => $result['user']->role,
                    'name'    => $result['user']->name,
                    'phone'   => $result['user']->phone,
                    'balance' => $result['user']->balance,
                ],
                'token'      => $result['token'],
                'token_type' => 'Bearer'
            ]
        ], 200);
    }

    public function profile(): JsonResponse{
        $user = $this->authService->profile();
        return response()->json([
            'status' => 'success',
            'message' => 'Token faol And Profile',
            'data' => [
                'user' => [
                    'id'      => $user->id,
                    'role'    => $user->role,
                    'name'    => $user->name,
                    'phone'   => $user->phone,
                    'balance' => $user->balance,
                ]
            ]
        ], 200);
    }

    public function logout(): JsonResponse{
        $this->authService->logout(Auth::user());
        return response()->json([
            'status' => 'success',
            'message' => 'Tizimdan muvaffaqiyatli chiqdingiz'
        ], 200);
    }

    public function updatePassword(ChangePasswordRequest $request): JsonResponse{
        $this->authService->changePassword(Auth::user(), $request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Parolingiz muvaffaqiyatli yangilandi.'
        ], 200);
    }


}
