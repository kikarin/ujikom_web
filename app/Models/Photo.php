<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_url',
        'gallery_id'
    ];

    protected $appends = ['full_image_url'];

    public function getFullImageUrlAttribute()
    {
        if (!$this->image_url) {
            return asset('images/placeholder.jpg');
        }

        // Jika path dari backend Android (public/images)
        if (Str::contains($this->image_url, 'public/images')) {
            return url(Storage::url($this->image_url));
        }

        // Jika path dari storage URL
        if (Str::startsWith($this->image_url, '/storage')) {
            return url($this->image_url);
        }

        // Jika URL lengkap
        if (Str::startsWith($this->image_url, 'http')) {
            return $this->image_url;
        }

        // Default: gunakan storage URL
        return Storage::url($this->image_url);
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes', 'photo_id', 'user_id');
    }

    public function isLikedBy($user)
    {
        if (!$user) {
            return false;
        }
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    // Helper method untuk menyimpan foto dari Flutter
    public static function saveFromFlutter($data)
    {
        $photo = new self();
        $photo->title = $data['title'];
        $photo->description = $data['description'] ?? null;
        $photo->gallery_id = $data['gallery_id'];
        
        // Jika image_url dari Flutter sudah lengkap dengan domain
        if (isset($data['image_url']) && str_starts_with($data['image_url'], 'http')) {
            $photo->image_url = $data['image_url'];
        } 
        // Jika image_url hanya path relatif
        else if (isset($data['image_url'])) {
            // Pastikan format path konsisten
            $path = str_replace(['public/', 'storage/'], '', $data['image_url']);
            if (!str_starts_with($path, 'photos/')) {
                $path = 'photos/' . $path;
            }
            $photo->image_url = $path;
        }

        $photo->save();
        return $photo;
    }
}

