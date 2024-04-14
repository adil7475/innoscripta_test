<?php

namespace App\Http\Controllers;

use App\Services\Source\SourceService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SourceController extends Controller
{
    /**
     * @param SourceService $sourceService
     * @return AnonymousResourceCollection
     */
    public function __invoke(SourceService $sourceService): AnonymousResourceCollection
    {
        return $sourceService->index();
    }
}
