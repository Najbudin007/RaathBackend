<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscriber::query();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('email', 'like', "%{$request->search}%")
                  ->orWhere('name', 'like', "%{$request->search}%")
                  ->orWhere('city', 'like', "%{$request->search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('city') && $request->city != '') {
            $query->where('city', $request->city);
        }

        $subscribers = $query->orderBy('created_at', 'desc')->paginate(20);
        $cities = Subscriber::distinct()->pluck('city')->filter()->sort()->values();
        
        $stats = [
            'total' => Subscriber::count(),
            'active' => Subscriber::where('status', 'active')->count(),
            'email_opt_in' => Subscriber::where('email_opt_in', true)->count(),
            'whatsapp_opt_in' => Subscriber::where('whatsapp_opt_in', true)->count(),
        ];

        return view('admin.pages.subscribers.index', compact('subscribers', 'cities', 'stats'));
    }

    public function create()
    {
        return view('admin.pages.subscribers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:subscribers,email',
            'city' => 'nullable|string|max:255',
            'membership_status' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,unsubscribed',
            'whatsapp_opt_in' => 'boolean',
            'email_opt_in' => 'boolean',
        ]);

        Subscriber::create([
            'name' => $request->name,
            'email' => $request->email,
            'city' => $request->city,
            'membership_status' => $request->membership_status,
            'status' => $request->status,
            'whatsapp_opt_in' => $request->has('whatsapp_opt_in'),
            'email_opt_in' => $request->has('email_opt_in'),
        ]);

        return redirect()->route('admin.subscribers.index')->with('success', 'Subscriber added successfully!');
    }

    public function show(Subscriber $subscriber)
    {
        return view('admin.pages.subscribers.show', compact('subscriber'));
    }

    public function edit(Subscriber $subscriber)
    {
        return view('admin.pages.subscribers.edit', compact('subscriber'));
    }

    public function update(Request $request, Subscriber $subscriber)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:subscribers,email,' . $subscriber->id,
            'city' => 'nullable|string|max:255',
            'membership_status' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,unsubscribed',
            'whatsapp_opt_in' => 'boolean',
            'email_opt_in' => 'boolean',
        ]);

        $subscriber->update([
            'name' => $request->name,
            'email' => $request->email,
            'city' => $request->city,
            'membership_status' => $request->membership_status,
            'status' => $request->status,
            'whatsapp_opt_in' => $request->has('whatsapp_opt_in'),
            'email_opt_in' => $request->has('email_opt_in'),
        ]);

        return redirect()->route('admin.subscribers.index')->with('success', 'Subscriber updated successfully!');
    }

    public function destroy($id)
    {
        try {
            $subscriber = Subscriber::findOrFail($id);
            $subscriber->delete();

            return response()->json([
                'success' => true,
                'message' => 'Subscriber deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete subscriber.'
            ], 404);
        }
    }

    public function toggleStatus(Subscriber $subscriber)
    {
        try {
            $subscriber->update(['is_active' => !$subscriber->is_active]);
            $status = $subscriber->is_active ? 'activated' : 'deactivated';

            return response()->json([
                'success' => true,
                'message' => "Subscriber {$status} successfully!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status.'
            ], 500);
        }
    }

    public function export()
    {
        $subscribers = Subscriber::where('is_active', true)->pluck('email');
        
        $filename = 'subscribers_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($subscribers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Email', 'Subscribed Date']);
            
            foreach (Subscriber::where('is_active', true)->get() as $subscriber) {
                fputcsv($file, [$subscriber->email, $subscriber->created_at->format('Y-m-d')]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

