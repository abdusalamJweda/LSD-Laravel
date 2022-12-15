<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create('ar_JO');

        \App\Models\User::factory(5)->create([
            'name' => $faker->name,
            'email' => 'jweda@jweda.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
            'type' => 'user',
            'date_of_birth' => $faker->date(),
            'sex' => 1,
            'bio' => 'هني المفروض يكون بايو هني المفروض يكون بايو هني المفروض يكون بايو هني المفروض يكون بايو هني المفروض يكون بايو '
        ]);
        \App\Models\Meme::factory(10)->create([
            'user_id' => User::all()->random()->id,
            'title' => $faker->word,
            'body' => $faker->realText,
            'city' => "طرابلس", 
            'type' => 'كلمة',
           'example' => $faker->paragraph
        ]);
    }
}
