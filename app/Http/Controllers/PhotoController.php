<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\Comment;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::all()->map(function($photo) {
            $photo->image_url = $this->getFullImageUrl($photo->image_url);
            return $photo;
        });
        return view('photos.index', compact('photos'));
    }

    public function show($id)
    {
        $photo = Photo::with(['comments.user', 'likes'])
            ->findOrFail($id);

        $photo->image_url = $this->getFullImageUrl($photo->image_url);

        return view('photos.show', compact('photo'));
    }

    public function create(Request $request)
    {
        $galleryId = $request->query('gallery_id');
        return view('photos.create', compact('galleryId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:51200',
            'gallery_id' => 'required|exists:galleries,id'
        ]);

        try {
            $photo = new Photo();
            $photo->title = $validated['title'];
            $photo->description = $validated['description'];
            $photo->gallery_id = $validated['gallery_id'];
            
            if ($request->hasFile('image')) {
                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $path = $request->file('image')->storeAs('public/photos', $fileName);
                $photo->image_url = asset('storage/photos/' . $fileName);
            }
            else if ($request->has('image_url')) {
                $photo->image_url = $request->image_url;
            }

            $photo->save();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Photo uploaded successfully',
                    'photo' => $photo
                ], 201);
            }

            return redirect()
                ->route('dashboard.galleries.show', $photo->gallery_id)
                ->with('success', 'Photo uploaded successfully!');

        } catch (\Exception $e) {
            \Log::error('Photo upload error: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to upload photo: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Failed to upload photo: ' . $e->getMessage());
        }
    }

    public function edit(Photo $photo)
    {
        $photo->image_url = $this->getFullImageUrl($photo->image_url);
        return view('admin.photos.edit', compact('photo'));
    }

    public function update(Request $request, Photo $photo)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:51200',
        ]);

        try {
            if ($request->hasFile('image')) {
                $oldPath = str_replace(asset('storage/'), 'public/', $photo->image_url);
                if (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }

                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $path = $request->file('image')->storeAs('public/photos', $fileName);
                $validated['image_url'] = asset('storage/photos/' . $fileName);
            }

            $photo->update($validated);

            return redirect()
                ->route('dashboard.galleries.show', $photo->gallery_id)
                ->with('success', 'Photo updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Photo update error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update photo: ' . $e->getMessage());
        }
    }

    public function destroy(Photo $photo)
    {
        try {
            if ($photo->image_url) {
                $path = str_replace(asset('storage/'), 'public/', $photo->image_url);
                if (Storage::exists($path)) {
                    Storage::delete($path);
                }
            }

            $galleryId = $photo->gallery_id;
            $photo->delete();

            return redirect()
                ->route('dashboard.galleries.show', $galleryId)
                ->with('success', 'Photo deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Photo delete error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete photo: ' . $e->getMessage());
        }
    }

    private function getFullImageUrl($path)
    {
        if (!$path) {
            return asset('images/placeholder.jpg');
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        $path = str_replace('public/', '', $path);
        
        return Storage::disk('public')->url($path);
    }

    public function toggleLike($id)
    {
        try {
            \Log::info('Toggle like started for photo: ' . $id);
            
            $photo = Photo::findOrFail($id);
            $user = auth()->user();

            if (!$user) {
                throw new \Exception('User not authenticated');
            }

            \Log::info('User attempting like: ' . $user->id);

            $existingLike = Like::where('photo_id', $photo->id)
                               ->where('user_id', $user->id)
                               ->first();

            if ($existingLike) {
                \Log::info('Deleting existing like');
                $existingLike->delete();
                $liked = false;
            } else {
                \Log::info('Creating new like');
                Like::create([
                    'user_id' => $user->id,
                    'photo_id' => $photo->id
                ]);
                $liked = true;
            }

            $likeCount = Like::where('photo_id', $photo->id)->count();
            \Log::info('Like count: ' . $likeCount);

            return response()->json([
                'success' => true,
                'liked' => $liked,
                'likesCount' => $likeCount,
                'message' => $liked ? 'Photo liked successfully' : 'Photo unliked successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Like Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to process like: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeComment(Request $request, $id)
    {
        try {
            \Log::info('Store comment started for photo: ' . $id);
            
            $request->validate([
                'content' => 'required|string|max:1000',
            ]);

            $photo = Photo::findOrFail($id);
            $user = auth()->user();

            if (!$user) {
                throw new \Exception('User not authenticated');
            }
            
            \Log::info('User attempting comment: ' . $user->id);

            $comment = Comment::create([
                'user_id' => $user->id,
                'photo_id' => $photo->id,
                'content' => $request->content
            ]);

            $comment->load('user');

            \Log::info('Comment created successfully');

            return response()->json([
                'success' => true,
                'message' => 'Comment posted successfully',
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'user' => [
                        'id' => $comment->user->id,
                        'name' => $comment->user->name
                    ],
                    'created_at' => $comment->created_at->diffForHumans()
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Comment Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to post comment: ' . $e->getMessage()
            ], 500);
        }
    }
}

