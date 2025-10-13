<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'designation' => $this->designation,
            'icon' => Str::storage_path($this->icon),
            'logo' => Str::storage_path($this->logo),
            'description' => $this->description,
            'rating' => $this->rating,
            'url' => $this->url,
        ];
    }
}
