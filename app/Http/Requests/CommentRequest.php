<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest {
    public function rules() {
        return [
            'content' => 'required|string',
            'photo_id' => 'required|exists:photos,id',
        ];
    }
}

