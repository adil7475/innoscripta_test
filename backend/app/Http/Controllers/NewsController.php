<?php

namespace App\Http\Controllers;

use App\Enums\CommonEnum;
use App\Http\Resources\News\NewsResource;
use App\Models\News;
use App\Models\User;
use App\Services\News\NewsService;
use App\Services\ResponseService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends Controller
{
    /**
     * @param NewsService $newsService
     * @return AnonymousResourceCollection
     */
    public function index(NewsService $newsService): AnonymousResourceCollection
    {
        return $newsService->index();
    }

    /**
     * @param NewsService $newsService
     * @param ResponseService $responseService
     * @return JsonResponse
     */
    public function feeds(NewsService $newsService, ResponseService $responseService): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $news = $newsService->getUserFeed($user);
        return $responseService->jsonResponse(
            Response::HTTP_OK,
            CommonEnum::SUCCESS,
            '',
            NewsResource::collection($news)
        );
    }
}
