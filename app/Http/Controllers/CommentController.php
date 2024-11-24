<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with('user', 'photo')->paginate(10);
        return view('comments.index', compact('comments'));
    }

    public function create()
    {
        return view('comments.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'photo_id' => 'required|exists:photos,id',
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        Comment::create($validatedData);

        return redirect()->route('comments.index')->with('success', 'Comment created successfully.');
    }

    public function edit(Comment $comment)
    {
        if (Auth::id() === $comment->user_id) {
            return view('comments.edit', compact('comment'));
        }
        return back()->with('error', 'Anda tidak diizinkan mengedit komentar ini.');
    }
    
    public function update(Request $request, Comment $comment)
    {
        if (Auth::id() !== $comment->user_id && !Auth::user()->role === 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment->update($validated);

        return response()->json([
            'success' => true,
            'content' => $comment->content,
            'message' => 'Comment updated successfully'
        ]);
    }
    
    
    public function destroy(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id && !Auth::user()->role === 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully'
        ]);
    }
}


