<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $attributes = [
        'role' => 'user', // Ganti 'default_role' dengan nilai default yang diinginkan
    ];
    
//     public function setPasswordAttribute($password)
// {
//     $this->attributes['password'] = bcrypt($password);
// }

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function galleries() {
        return $this->hasMany(Gallery::class);
    }
    
    public function photos() {
        return $this->hasMany(Photo::class);
    }
       
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likedPhotos()
    {
        return $this->belongsToMany(Photo::class, 'likes', 'user_id', 'photo_id');
    }

}
