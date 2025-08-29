<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subscriber\SubscribeRequest;
use App\Http\Resources\SubscriberResource;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /**
     * Display a listing of subscribers (admin only).
     */
    public function index(Request $request): JsonResponse
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.',
            ], 403);
        }

        $query = Subscriber::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by city
        if ($request->has('city')) {
            $query->byCity($request->city);
        }

        // Filter by membership status
        if ($request->has('membership_status')) {
            $query->byMembershipStatus($request->membership_status);
        }

        $subscribers = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json([
            'success' => true,
            'message' => 'Subscribers retrieved successfully',
            'data' => SubscriberResource::collection($subscribers),
            'pagination' => [
                'current_page' => $subscribers->currentPage(),
                'last_page' => $subscribers->lastPage(),
                'per_page' => $subscribers->perPage(),
                'total' => $subscribers->total(),
            ],
        ]);
    }

    /**
     * Subscribe to newsletter.
     */
    public function subscribe(SubscribeRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        // Check if email already exists
        $existingSubscriber = Subscriber::where('email', $data['email'])->first();
        
        if ($existingSubscriber) {
            if ($existingSubscriber->isUnsubscribed()) {
                // Resubscribe
                $existingSubscriber->resubscribe();
                $existingSubscriber->update($data);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully resubscribed to newsletter',
                    'data' => new SubscriberResource($existingSubscriber),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Email is already subscribed',
                ], 400);
            }
        }

        // Create new subscriber
        $subscriber = Subscriber::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Successfully subscribed to newsletter',
            'data' => new SubscriberResource($subscriber),
        ], 201);
    }

    /**
     * Unsubscribe from newsletter.
     */
    public function unsubscribe(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $subscriber = Subscriber::where('email', $request->email)->first();

        if (!$subscriber) {
            return response()->json([
                'success' => false,
                'message' => 'Subscriber not found',
            ], 404);
        }

        $subscriber->unsubscribe();

        return response()->json([
            'success' => true,
            'message' => 'Successfully unsubscribed from newsletter',
        ]);
    }

    /**
     * Get subscriber statistics (admin only).
     */
    public function statistics(Request $request): JsonResponse
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.',
            ], 403);
        }

        $totalSubscribers = Subscriber::count();
        $activeSubscribers = Subscriber::active()->count();
        $unsubscribedSubscribers = Subscriber::unsubscribed()->count();
        $emailOptInSubscribers = Subscriber::emailOptIn()->count();
        $whatsappOptInSubscribers = Subscriber::whatsappOptIn()->count();

        $subscribersByCity = Subscriber::selectRaw('city, COUNT(*) as count')
            ->whereNotNull('city')
            ->groupBy('city')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Subscriber statistics retrieved successfully',
            'data' => [
                'total_subscribers' => $totalSubscribers,
                'active_subscribers' => $activeSubscribers,
                'unsubscribed_subscribers' => $unsubscribedSubscribers,
                'email_opt_in_subscribers' => $emailOptInSubscribers,
                'whatsapp_opt_in_subscribers' => $whatsappOptInSubscribers,
                'subscribers_by_city' => $subscribersByCity,
            ],
        ]);
    }
}
