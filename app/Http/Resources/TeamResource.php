<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
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
            'name' => $this->name,
            'position' => $this->position,
            'description' => $this->description,
            'image' => Str::storage_path($this->image),
            'type' => $this->type,
            'achievements' => $this->achievements,
            'contact' => [
                'email' => $this->email,
                'facebook' => $this->facebook,
                'linkedin' => $this->linkedin,
                'website' => $this->website,
                'phone' => $this->phone,
            ]
        ];
    }
}
