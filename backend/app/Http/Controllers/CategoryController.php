<?php

namespace App\Http\Controllers;

use App\Services\Category\CategoryService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    /**
     * @param CategoryService $categoryService
     * @return AnonymousResourceCollection
     */
    public function __invoke(CategoryService $categoryService): AnonymousResourceCollection
    {
        return $categoryService->index();
    }
}
