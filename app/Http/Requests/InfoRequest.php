<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InfoRequest extends FormRequest {
    public function rules() {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ];
    }
}

