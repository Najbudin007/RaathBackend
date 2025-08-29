<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user_id' => $this->user_id,
            'order_number' => $this->order_number,
            'subtotal' => $this->subtotal,
            'tax' => $this->tax,
            'shipping' => $this->shipping,
            'total' => $this->total,
            'status' => $this->status,
            'shipping_address' => $this->shipping_address,
            'billing_address' => $this->billing_address,
            'phone' => $this->phone,
            'email' => $this->email,
            'notes' => $this->notes,
            'payment_method' => $this->payment_method,
            'transaction_id' => $this->transaction_id,
            'order_items' => $this->whenLoaded('orderItems'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
