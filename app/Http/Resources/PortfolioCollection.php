<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PortfolioCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($portfolio) {
                $data = [
                    'slug' => $portfolio->slug,
                    'title' => $portfolio->title,
                    'description' => $portfolio->description,
                    'case_study' => $portfolio->case_study,
                    'feature_image' => Str::storage_path($portfolio->feature_image),
                    'date' => $portfolio->created_at->format('d M, Y'),
                ];
    
                if ($portfolio->relationLoaded('category')) {
                    $data['category'] = new PortfolioCategoryResource($portfolio->category);
                }
    
                return $data;
            }),
            'pagination' => [
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage(),
                'per_page' => $this->perPage(),
                'total' => $this->total(),
                'next_page' => $this->nextPageUrl(),
                'prev_page' => $this->previousPageUrl(),
            ]
        ];
    }
}