<?php

namespace Database\Factories;

use App\Models\Picture;
use App\Models\Album;
use Illuminate\Database\Eloquent\Factories\Factory;

class PictureFactory extends Factory {
    protected $model = Picture::class;

    public function definition() {
        return [
            'image_url' => $this->faker->imageUrl(),
            'album_id' => Album::factory(),
        ];
    }
}
