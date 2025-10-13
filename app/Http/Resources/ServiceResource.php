<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =  [
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'icon' => Str::storage_path($this->icon),
            'description' => $this->description,
            
        ];
       
        if (isset($this->categories)) {
            $data['categories'] = $this->categories->map(function($category) {
                return [
                    'title' => $category->title,
                    'slug' => $category->slug
                ];
            });
        }
        return $data;
    }
}
