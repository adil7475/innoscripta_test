<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\News\AuthorResource;
use App\Http\Resources\News\CategoryResource;
use App\Http\Resources\News\SourceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSettingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'sources' => SourceResource::collection($this->sources),
            'categories' => CategoryResource::collection($this->categories),
            'authors' => AuthorResource::collection($this->authors)
        ];
    }
}
