<?php

namespace App\Http\Resources\News;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'source' => new SourceResource($this->source),
            'category' => new CategoryResource($this->category),
            'author' => new AuthorResource($this->author),
            'published_at' => Carbon::parse($this->date)->format('Y-m-d'),
            'image_url' => $this->image_url
        ];
    }
}
