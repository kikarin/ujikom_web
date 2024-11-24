<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with(['photos' => function($query) {
            $query->orderBy('created_at', 'desc')
                ->get()
                ->map(function($photo) {
                    if ($photo->image_url && !str_starts_with($photo->image_url, 'http')) {
                        $photo->image_url = asset($photo->image_url);
                    }
                    return $photo;
                });
        }])
        ->orderBy('created_at', 'desc')
        ->get();

        return view('gallery.index', compact('galleries'));
    }

    public function userIndex(Request $request)
    {
        $search = $request->input('search');

        $galleries = Gallery::with(['photos' => function($query) {
            $query->orderBy('created_at', 'desc')
                ->get()
                ->map(function($photo) {
                    if ($photo->image_url && !str_starts_with($photo->image_url, 'http')) {
                        $photo->image_url = asset($photo->image_url);
                    }
                    return $photo;
                });
        }])
        ->when($search, function($query, $search) {
            return $query->where('title', 'like', "%{$search}%");
        })
        ->paginate(9);

        return view('gallery.index', compact('galleries', 'search'));
    }

    public function show($id)
    {
        $gallery = Gallery::with(['photos' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);
        
        return view('admin.galleries.show', compact('gallery'));
    }

    public function userShow(Gallery $gallery)
    {
        return view('gallery.show', compact('gallery'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        // Validasi dan simpan galeri baru
        $validatedData = $request->validate([
            'title' => 'required|max:255',
        ]);

        $validatedData['user_id'] = Auth::id();

        $gallery = Gallery::create($validatedData);

        // Log aktivitas
        Log::info(Auth::user()->name . ' created a new gallery: ' . $gallery->title);


        return redirect()->route('dashboard.galleries.index')->with('success', 'Galeri berhasil dibuat.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery')); // Admin edit galeri
    }

    public function update(Request $request, Gallery $gallery)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|max:255',
            ]);

            $gallery->update([
                'title' => $validatedData['title'],
                'user_id' => Auth::id() // Pastikan user_id diisi
            ]);

            // Log aktivitas
            Log::info(Auth::user()->name . ' updated the gallery: ' . $gallery->title);

            return redirect()
                ->route('dashboard.galleries.index')
                ->with('success', 'Gallery updated successfully.');
        } catch (\Exception $e) {
            Log::error('Gallery Update Error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Failed to update gallery. ' . $e->getMessage());
        }
    }

    public function destroy(Gallery $gallery)
    {
        $title = $gallery->title;
        $gallery->delete();

        // Log aktivitas
        Log::info(Auth::user()->name . ' deleted the gallery: ' . $title);


        return redirect()->route('dashboard.galleries.index')->with('success', 'Gallery deleted successfully.');
    }

    public function adminIndex()
    {
        $galleries = Gallery::with(['photos' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])
        ->orderBy('created_at', 'desc')
        ->get();

        return view('admin.galleries.index', compact('galleries'));
    }
}
