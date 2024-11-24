<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgendaRequest extends FormRequest {
    public function rules() {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',  // Pastikan ini ada di request
            'event_date' => 'required|date'
        ];
    }
}

