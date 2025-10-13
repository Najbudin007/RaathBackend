<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CareerDetailResource extends JsonResource
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
            'job_type' => $this->job_type,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => Str::storage_path($this->image),
            'expired_date' => $this->expired_date,
            'position' => $this->role->title ?? null,   
        ];
    }
}
