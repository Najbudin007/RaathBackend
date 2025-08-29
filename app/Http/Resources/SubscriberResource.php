<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriberResource extends JsonResource
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
            'email' => $this->email,
            'city' => $this->city,
            'membership_status' => $this->membership_status,
            'whatsapp_opt_in' => $this->whatsapp_opt_in,
            'email_opt_in' => $this->email_opt_in,
            'status' => $this->status,
            'email_verified_at' => $this->email_verified_at,
            'preferences' => $this->preferences,
            'is_verified' => $this->isVerified(),
            'is_active' => $this->isActive(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
