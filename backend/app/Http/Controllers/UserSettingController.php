<?php

namespace App\Http\Controllers;

use App\Enums\CommonEnum;
use App\Http\Requests\User\SettingUpdateRequest;
use App\Services\ResponseService;
use App\Services\User\UserSettingService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserSettingController extends Controller
{
    /**
     * @param SettingUpdateRequest $request
     * @param UserSettingService $userSettingService
     * @param ResponseService $responseService
     * @return JsonResponse
     */
    public function __invoke(SettingUpdateRequest $request, UserSettingService $userSettingService, ResponseService $responseService): JsonResponse
    {
        $data = $request->validated();
        $userSettingService->update($data, auth()->id());

        return $responseService->jsonResponse(
            Response::HTTP_OK,
            CommonEnum::SUCCESS,
            trans('User settings has been updated.'),
            []
        );
    }
}
