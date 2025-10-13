<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $query = Donation::with(['user', 'project']);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('donor_name', 'like', "%{$request->search}%")
                  ->orWhere('donor_email', 'like', "%{$request->search}%")
                  ->orWhere('transaction_id', 'like', "%{$request->search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('project_id') && $request->project_id != '') {
            $query->where('project_id', $request->project_id);
        }

        if ($request->has('payment_method') && $request->payment_method != '') {
            $query->where('payment_method', $request->payment_method);
        }

        $donations = $query->orderBy('created_at', 'desc')->paginate(20);
        $projects = Project::orderBy('title')->get();
        
        $stats = [
            'total_donations' => Donation::count(),
            'total_amount' => Donation::where('status', 'completed')->sum('amount'),
            'pending_amount' => Donation::where('status', 'pending')->sum('amount'),
            'completed_count' => Donation::where('status', 'completed')->count(),
        ];

        return view('admin.pages.donations.index', compact('donations', 'projects', 'stats'));
    }

    public function create()
    {
        $projects = Project::where('status', 'active')->orderBy('title')->get();
        $users = User::orderBy('name')->get();
        return view('admin.pages.donations.create', compact('projects', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'donor_phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:0',
            'message' => 'nullable|string',
            'payment_method' => 'required|string|max:255',
            'status' => 'required|in:pending,completed,failed,refunded',
            'transaction_id' => 'nullable|string|max:255',
            'is_anonymous' => 'boolean',
        ]);

        $data['is_anonymous'] = $request->has('is_anonymous');

        Donation::create($data);

        return redirect()->route('admin.donations.index')->with('success', 'Donation recorded successfully!');
    }

    public function show(Donation $donation)
    {
        $donation->load(['user', 'project']);
        return view('admin.pages.donations.show', compact('donation'));
    }

    public function edit(Donation $donation)
    {
        $projects = Project::orderBy('title')->get();
        $users = User::orderBy('name')->get();
        return view('admin.pages.donations.edit', compact('donation', 'projects', 'users'));
    }

    public function update(Request $request, Donation $donation)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'donor_phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:0',
            'message' => 'nullable|string',
            'payment_method' => 'required|string|max:255',
            'status' => 'required|in:pending,completed,failed,refunded',
            'transaction_id' => 'nullable|string|max:255',
            'is_anonymous' => 'boolean',
        ]);

        $data['is_anonymous'] = $request->has('is_anonymous');

        $donation->update($data);

        return redirect()->route('admin.donations.index')->with('success', 'Donation updated successfully!');
    }

    public function destroy($id)
    {
        try {
            $donation = Donation::findOrFail($id);
            $donation->delete();

            return response()->json([
                'success' => true,
                'message' => 'Donation deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete donation.'
            ], 404);
        }
    }

    public function updateStatus(Request $request, Donation $donation)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,failed,refunded'
        ]);

        try {
            $donation->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => "Donation status updated to {$request->status} successfully!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status.'
            ], 500);
        }
    }
}

