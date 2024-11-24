<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
    ];

    // Relasi ke Pictures (one-to-many)
    public function pictures()
    {
        return $this->hasMany(Picture::class);
    }

    // Relasi ke User (belongs-to)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 