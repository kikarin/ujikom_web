<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory {
    protected $model = Comment::class;

    public function definition() {
        return [
            'content' => $this->faker->text(),
            'photo_id' => Photo::factory(),
            'user_id' => User::factory(),
        ];
    }
}
