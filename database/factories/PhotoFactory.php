<?php

namespace Database\Factories;

use App\Models\Photo;
use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoFactory extends Factory {
    protected $model = Photo::class;

    public function definition() {
        return [
            'image_url' => $this->faker->imageUrl(),
            'gallery_id' => Gallery::factory(),
        ];
    }
}
