<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BudgetBreakdown;
use App\Models\Project;
use Illuminate\Http\Request;

class BudgetBreakdownController extends Controller
{
    public function index(Request $request)
    {
        $query = BudgetBreakdown::with('project');

        if ($request->has('project_id') && $request->project_id != '') {
            $query->where('project_id', $request->project_id);
        }

        $budgets = $query->orderBy('project_id')->orderBy('category')->paginate(15);
        $projects = Project::orderBy('title')->get();

        return view('admin.pages.budget-breakdowns.index', compact('budgets', 'projects'));
    }

    public function create()
    {
        $projects = Project::orderBy('title')->get();
        return view('admin.pages.budget-breakdowns.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
        ]);

        BudgetBreakdown::create($data);

        return redirect()->route('admin.budget-breakdowns.index')->with('success', 'Budget breakdown created successfully!');
    }

    public function show(BudgetBreakdown $budgetBreakdown)
    {
        $budgetBreakdown->load('project');
        return view('admin.pages.budget-breakdowns.show', compact('budgetBreakdown'));
    }

    public function edit(BudgetBreakdown $budgetBreakdown)
    {
        $projects = Project::orderBy('title')->get();
        return view('admin.pages.budget-breakdowns.edit', compact('budgetBreakdown', 'projects'));
    }

    public function update(Request $request, BudgetBreakdown $budgetBreakdown)
    {
        $data = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
        ]);

        $budgetBreakdown->update($data);

        return redirect()->route('admin.budget-breakdowns.index')->with('success', 'Budget breakdown updated successfully!');
    }

    public function destroy($id)
    {
        try {
            BudgetBreakdown::findOrFail($id)->delete();
            return response()->json(['success' => true, 'message' => 'Budget deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete.'], 404);
        }
    }
}

