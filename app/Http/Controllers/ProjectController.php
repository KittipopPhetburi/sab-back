<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('customer')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($project) {
                return [
                    'id' => $project->id,
                    'code' => $project->code,
                    'name' => $project->name,
                    'customer' => $project->customer->name,
                    'customer_id' => $project->customer_id,
                    'amount' => (float) $project->amount,
                    'installments' => $project->installments,
                    'guarantee' => (float) $project->guarantee,
                    'start_date' => $project->start_date->format('Y-m-d'),
                    'end_date' => $project->end_date ? $project->end_date->format('Y-m-d') : null,
                    'description' => $project->description,
                    'status' => $project->status,
                    'budget' => (float) $project->amount, // For compatibility
                    'progress' => $project->installments,
                    'created_at' => $project->created_at,
                    'updated_at' => $project->updated_at,
                ];
            });

        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:projects,code',
            'customer_id' => 'required|exists:customers,id',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'installments' => 'required|integer|min:1',
            'guarantee' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'status' => 'nullable|in:กำลังดำเนินงาน,จบโครงการแล้ว,ยกเลิก',
        ]);

        $project = Project::create($validated);
        $project->load('customer');

        return response()->json($project, 201);
    }

    public function show($id)
    {
        $project = Project::with('customer')->findOrFail($id);
        return response()->json($project);
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:projects,code,' . $id,
            'customer_id' => 'required|exists:customers,id',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'installments' => 'required|integer|min:1',
            'guarantee' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'status' => 'nullable|in:กำลังดำเนินงาน,จบโครงการแล้ว,ยกเลิก',
        ]);

        $project->update($validated);
        $project->load('customer');

        return response()->json($project);
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully']);
    }
}
