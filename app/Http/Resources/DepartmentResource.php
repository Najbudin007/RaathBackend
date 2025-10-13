<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'description' => strip_tags($this->description, '<br><br/>'),
            'icon' => $this->icon,
            'color' => $this->color,
            'requirements' => $this->requirements,
            'time' => $this->time,
            'unit' => $this->unit,
        ];
    }
}
