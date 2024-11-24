<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PictureController extends Controller
{
    public function index()
    {
        $pictures = Picture::all();
        return view('pictures.index', compact('pictures'));
    }

    public function create(Request $request)
    {
        $albumId = $request->query('album_id');
        return view('pictures.create', compact('albumId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:51200',
            'album_id' => 'required|exists:albums,id'
        ]);

        $album = Album::findOrFail($request->album_id);
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    // Simpan file dengan nama unik
                    $fileName = time() . '_' . $image->getClientOriginalName();
                    // Simpan ke storage/app/public/pictures
                    $path = $image->storeAs('public/pictures', $fileName);
                    // Generate URL yang bisa diakses publik
                    $imageUrl = asset('storage/pictures/' . $fileName);

                    Picture::create([
                        'album_id' => $album->id,
                        'image_url' => $imageUrl,
                    ]);
                }
            }
        }

        return redirect()->route('dashboard.albums.show', $album)
            ->with('success', 'Pictures uploaded successfully');
    }

    public function show($id)
    {
        $picture = Picture::findOrFail($id);
        return view('pictures.show', compact('picture'));
    }
    

    public function edit(Picture $picture)
    {
        return view('admin.pictures.edit', compact('picture'));
    }

    public function update(Request $request, Picture $picture)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:51200'
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            $oldPath = str_replace('/storage/', 'public/', $picture->image_url);
            if (Storage::exists($oldPath)) {
                Storage::delete($oldPath);
            }

            // Upload gambar baru
            $path = $request->file('image')->store('public/images');
            $picture->image_url = Storage::url($path);
            $picture->save();
        }

        return redirect()->route('dashboard.albums.show', $picture->album_id)
            ->with('success', 'Picture updated successfully');
    }

    

    public function destroy(Picture $picture)
    {
        $albumId = $picture->album_id;
        
        // Hapus file dari storage
        $path = str_replace('/storage/', 'public/', $picture->image_url);
        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        $picture->delete();

        return redirect()->route('dashboard.albums.show', $albumId)
            ->with('success', 'Picture deleted successfully');
    }

    public function download($id)
    {
        // Find the picture by ID
        $picture = Picture::findOrFail($id);

        // Convert the image URL to the local storage path
        $path = str_replace('/storage/', 'public/', $picture->image_url);

        // Check if the image exists in storage
        if (Storage::exists($path)) {
            // Trigger the download of the image file
            return Storage::download($path, basename($picture->image_url));
        } else {
            // If the image doesn't exist, redirect with an error message
            return back()->with('error', 'File not found.');
        }
    }

    public function bulkDelete(Request $request)
{
    $validated = $request->validate([
        'picture_ids' => 'required|array',
        'picture_ids.*' => 'exists:pictures,id',
    ]);

    // Ambil ID gambar yang dipilih
    $pictureIds = $validated['picture_ids'];

    // Hapus gambar dari storage
    $pictures = Picture::whereIn('id', $pictureIds)->get();
    foreach ($pictures as $picture) {
        $path = str_replace('/storage/', 'public/', $picture->image_url);
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }

    // Hapus data gambar dari database
    Picture::whereIn('id', $pictureIds)->delete();

    return redirect()->route('dashboard.albums.show', $request->album_id)
        ->with('success', 'Selected pictures deleted successfully.');
}

} 