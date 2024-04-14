<?php

namespace App\Http\Controllers;

use App\Services\Author\AuthorService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthorController extends Controller
{
    /**
     * @param AuthorService $authorService
     * @return AnonymousResourceCollection
     */
    public function __invoke(AuthorService $authorService): AnonymousResourceCollection
    {
        return $authorService->index();
    }
}
