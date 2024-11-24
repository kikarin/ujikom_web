<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PictureRequest extends FormRequest {
    public function rules() {
        return [
            'image_url' => 'required|url',
            'album_id' => 'required|exists:albums,id',
        ];
    }
}

