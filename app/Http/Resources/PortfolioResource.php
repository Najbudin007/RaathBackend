<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'case_study' => $this->case_study,
            'feature_image' => Str::storage_path($this->feature_image),
            'category' => [
                'slug' => $this->category->slug ?? null,
                'title' => $this->category->title ?? null,
            ],
            'date' => $this->created_at->format('d M, Y'),
        ];
    }
}
