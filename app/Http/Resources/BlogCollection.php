<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BlogCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($blog) {
                $data =  [
                    'slug' => $blog->slug,
                    'title' => $blog->title,
                    'content' => $blog->content,
                    'meta_title' => $blog->meta_title,
                    'meta_keywords' => $blog->meta_keywords,
                    'meta_description' => $blog->meta_description,
                    'featured_image' => Str::storage_path($blog->featured_image),
                   
                    'date' => $blog->created_at->format('d M, Y'),
                ];
                if ($blog->relationLoaded('category')) {
                    $data['category'] = new BlogCategoryResource($blog->category);
                }

                if ($blog->relationLoaded('tags')) {
                    $data['tags'] = new TagResource($blog->category);
                }
                return $data;
            }),
            'pagination' => [
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage(),
                'per_page' => $this->perPage(),
                'total_blogs' => $this->total(),
                'next_page' => $this->nextPageUrl(),
                'prev_page' => $this->previousPageUrl(),
            ]
        ];
    }
}
