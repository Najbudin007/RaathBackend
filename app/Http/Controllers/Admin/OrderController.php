<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems']);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('order_number', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);
        
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total'),
            'pending_count' => Order::where('status', 'pending')->count(),
            'completed_count' => Order::where('status', 'completed')->count(),
        ];

        return view('admin.pages.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.pages.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('admin.pages.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled,refunded',
            'shipping_address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $order->update($data);

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully!');
    }

    public function destroy($id)
    {
        try {
            Order::findOrFail($id)->delete();
            return response()->json(['success' => true, 'message' => 'Order deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete.'], 404);
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,processing,completed,cancelled,refunded']);

        try {
            $order->update(['status' => $request->status]);
            return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update.'], 500);
        }
    }
}

