<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TaskController extends Controller
{
    public function index(Request $r, $projectId = null)
    {
        $query = Task::query()->with('assignee', 'comments.user');
        if ($projectId) $query->where('project_id', $projectId);
        return response()->json($query->get());
    }

    public function store(Request $r)
    {
        $r->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date'
        ]);
        $task = Task::create($r->only(['project_id', 'title', 'description', 'assigned_to', 'due_date']));
        return response()->json($task->load('assignee'), 201);
    }

    public function show(Task $task)
    {
        return response()->json($task->load('assignee', 'comments.user'));
    }

    public function update(Request $r, Task $task)
    {
        $task->update($r->only(['title', 'description', 'assigned_to', 'status', 'due_date']));
        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }

    public function markComplete(Task $task)
    {
        $task->update(['status' => 'done']);
        $payload = [
            'task_id' => $task->id,
            'project_id' => $task->project_id,
            'completed_by' => auth()->id(),
            'timestamp' => now()->toDateTimeString()
        ];
        try {
            Redis::publish('tasks.completed', json_encode($payload));
        } catch (\Exception $e) {
            \Log::error('Redis publish failed: ' . $e->getMessage());
        }
        return response()->json(['message' => 'Task marked as done', 'task' => $task]);
    }
}
