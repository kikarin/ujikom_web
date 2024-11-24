<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Gallery;
use App\Models\Photo;
use App\Models\Comment;
use App\Models\Album;
use App\Models\Picture;

class DatabaseSeeder extends Seeder {
    public function run() {
        // Membuat 10 User dengan masing-masing 2 Gallery
        User::factory(10)->create()->each(function ($user) {
            $galleries = Gallery::factory(2)->make(); // Gunakan 'make' untuk instansiasi tanpa menyimpan
            $user->galleries()->saveMany($galleries);

            $galleries->each(function ($gallery) {
                $photos = Photo::factory(3)->make(); // Gunakan 'make' untuk instansiasi tanpa menyimpan
                $gallery->photos()->saveMany($photos);

                $photos->each(function ($photo) {
                    $comments = Comment::factory(5)->make(); // Instansiasi komentar
                    $photo->comments()->saveMany($comments);
                });
            });
            $this->call(AdminSeeder::class);

 
        });
    }
}
