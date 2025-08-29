<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserMembershipResource extends JsonResource
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
            'membership_plan_id' => $this->membership_plan_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'amount_paid' => $this->amount_paid,
            'payment_method' => $this->payment_method,
            'transaction_id' => $this->transaction_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'membership_plan' => $this->whenLoaded('membershipPlan', function () {
                return new MembershipPlanResource($this->membershipPlan);
            }),
        ];
    }
}
