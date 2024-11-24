<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhotoRequest extends FormRequest {
    public function rules() {
        return [
            'image_url' => 'required|url',
            'gallery_id' => 'required|exists:galleries,id',
        ];
    }
}

