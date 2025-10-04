<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return response()->json(Project::where('owner_id', $user->id)->with('tasks')->get());
    }

    public function store(Request $r)
    {
        $r->validate(['name' => 'required|string|max:255']);
        $project = Project::create([
            'name' => $r->name,
            'description' => $r->description,
            'owner_id' => auth()->id()
        ]);
        return response()->json($project, 201);
    }

    public function show(Project $project)
    {
        return response()->json($project->load('tasks'));
    }

    public function update(Request $r, Project $project)
    {
        $project->update($r->only(['name', 'description']));
        return response()->json($project);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(null, 204);
    }
}
