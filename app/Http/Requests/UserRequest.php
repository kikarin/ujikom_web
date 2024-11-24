<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserRequest extends FormRequest {
    public function rules() {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:user,admin',
        ];
    }
}

$request = new Request();

// Manually set parameters on the request
$request->merge(['email' => 'example@example.com']);

// Now check if the email exists
$userRequest = new UserRequest();
// Output the result
echo $exists ? 'Exists' : 'Does not exist';