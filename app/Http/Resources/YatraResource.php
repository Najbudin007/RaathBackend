<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class YatraResource extends JsonResource
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
            'city' => $this->city,
            'month' => $this->month,
            'collaborating_center' => $this->collaborating_center,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'image' => $this->image,
            'details' => $this->details,
            'is_featured' => $this->is_featured,
            'sort_order' => $this->sort_order,
            'days_until_start' => $this->getDaysUntilStart(),
            'is_upcoming' => $this->isUpcoming(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
