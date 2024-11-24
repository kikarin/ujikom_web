<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with('pictures')->get();
        return view('admin.albums.index', compact('albums'));
    }

    public function userIndex()
    {
        $albums = Album::all();
        return view('albums.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.albums.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
        ]);

        // Tambahkan user_id dari user yang sedang login
        $validated['user_id'] = Auth::id();

        $album = Album::create($validated);

        // Log aktivitas
        Log::info(Auth::user()->name . ' created a new album: ' . $album->title);


        return redirect()->route('dashboard.albums.index')
            ->with('success', 'Album created successfully');
    }

    public function show($id)
    {
        $album = Album::with('pictures')->findOrFail($id);
        return view('admin.albums.show', compact('album'));
    }

    public function userShow(Album $album)
    {
        $album->load('pictures');
        return view('albums.show', compact('album'));
    }

    public function edit(Album $album)
    {
        $users = User::all();
        return view('admin.albums.edit', compact('album', 'users'));
    }

    public function update(Request $request, Album $album)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
        ]);
        $validated['user_id'] = Auth::id();

        $album->update($validated);

        // Log aktivitas
        Log::info(Auth::user()->name . ' updated the album: ' . $album->title);


        return redirect()->route('dashboard.albums.index')
            ->with('success', 'Album updated successfully');
    }

    public function destroy(Album $album)
    {
        $title = $album->title;
        $album->delete();

        // Log aktivitas
        Log::info(Auth::user()->name . ' deleted the album: ' . $title);


        return redirect()->route('dashboard.albums.index')
            ->with('success', 'Album deleted successfully');
    }
}
