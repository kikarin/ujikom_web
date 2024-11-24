<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),  // Ini bisa juga menggunakan `Hash::make('password')`
            'role' => $this->faker->randomElement(['user', 'admin']),
            'remember_token' => Str::random(10),
        ];
    }
}


