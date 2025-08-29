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
            'application_status' => $this->application_status,
            'photo_url' => $this->photo_url,
            'application_notes' => $this->application_notes,
            'membership_id_number' => $this->membership_id_number,
            'amount_paid' => $this->amount_paid,
            'payment_method' => $this->payment_method,
            'transaction_id' => $this->transaction_id,
            'approved_at' => $this->approved_at,
            'rejected_at' => $this->rejected_at,
            'rejection_reason' => $this->rejection_reason,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'membership_plan' => $this->whenLoaded('membershipPlan', function () {
                return new MembershipPlanResource($this->membershipPlan);
            }),
            'approved_by' => $this->whenLoaded('approvedBy', function () {
                return new UserResource($this->approvedBy);
            }),
            'rejected_by' => $this->whenLoaded('rejectedBy', function () {
                return new UserResource($this->rejectedBy);
            }),
        ];
    }
}
