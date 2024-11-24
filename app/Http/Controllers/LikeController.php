<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggleLike($photoId)
    {
        $photo = Photo::findOrFail($photoId);
        $user = Auth::user();
        
        $existingLike = Like::where('user_id', $user->id)
                           ->where('photo_id', $photo->id)
                           ->first();

        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id' => $user->id,
                'photo_id' => $photo->id
            ]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likesCount' => $photo->likes()->count()
        ]);
    }
}
