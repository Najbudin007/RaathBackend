<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'slug' => $this->slug,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'vision' => $this->vision,
            'technical_specs' => $this->technical_specs,
            'design_docs' => $this->design_docs,
            'image' => $this->image,
            'images' => $this->images,
            'target_amount' => $this->target_amount,
            'collected_amount' => $this->collected_amount,
            'budget' => $this->budget,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'is_featured' => $this->is_featured,
            'progress_percentage' => $this->progress_percentage,
            'days_remaining' => $this->days_remaining,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // Load relationships if requested
            'sponsorship_tiers' => $this->whenLoaded('sponsorshipTiers', function () {
                return SponsorshipTierResource::collection($this->sponsorshipTiers);
            }),
            'budget_breakdowns' => $this->whenLoaded('budgetBreakdowns', function () {
                return BudgetBreakdownResource::collection($this->budgetBreakdowns);
            }),
            'documents' => $this->whenLoaded('documents', function () {
                return DocumentResource::collection($this->documents);
            }),
        ];
    }
}
