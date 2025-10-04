<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $r)
    {
        $r->validate([
            'task_id' => 'required|exists:tasks,id',
            'body' => 'required|string'
        ]);
        $comment = Comment::create([
            'task_id' => $r->task_id,
            'user_id' => auth()->id(),
            'body' => $r->body
        ]);
        return response()->json($comment->load('user'), 201);
    }

    public function index($taskId)
    {
        return response()->json(Comment::where('task_id', $taskId)->with('user')->get());
    }
}
