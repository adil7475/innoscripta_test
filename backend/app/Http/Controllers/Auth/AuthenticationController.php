<?php

namespace App\Http\Controllers\Auth;

use App\Enums\CommonEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Users\UserResource;
use App\Models\User;
use App\Services\ResponseService;
use App\Services\User\UserService;
use App\Traits\AccessToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends Controller
{
    use AccessToken;

    public function register(RegisterRequest $request, UserService $userService): JsonResponse
    {
        $data = $request->validated();
        $user = $userService->store($data);
        $tokenProvider = $this->tokenKey($user->email);
        $token = $user->createToken($tokenProvider)->plainTextToken;

        return ResponseService::jsonResponse(
            Response::HTTP_CREATED,
            CommonEnum::SUCCESS,
            '',
            [
                'user' => new UserResource($user),
                'access_token' => $token
            ],
        );
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return ResponseService::jsonResponse(
                Response::HTTP_UNAUTHORIZED,
                CommonEnum::ERROR,
                'Invalid Credentials'
            );
        }

        $tokenProvider = $this->tokenKey($user->email);
        $token = $user->createToken($tokenProvider)->plainTextToken;

        return ResponseService::jsonResponse(
            Response::HTTP_OK,
            CommonEnum::SUCCESS,
            '',
            [
                'user' => new UserResource($user),
                'access_token' => $token
            ]
        );
    }
}
