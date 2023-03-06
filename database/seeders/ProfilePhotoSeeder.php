<?php

namespace Database\Seeders;

use App\Models\portfolio;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class ProfilePhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();

        $url = $faker->unique()->imageUrl();
        $path_parts = pathinfo($url);

        // Get all user ids
        $userIds = User::where('id', '>', 40)->pluck('id');

        // Loop through each user and create a profile photo
        foreach ($userIds as $userId) {
            $photo = new portfolio();
            $photo->user_id = $userId;
            $photo->file_name = $path_parts['filename'];
            $photo->ext = 'jpg';
            $photo->profile_photo = 1;
            $photo->contest_photo = 1;
            $photo->save();
        }
    }
}
