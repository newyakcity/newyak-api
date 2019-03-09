<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        DB::table('posts')->insert([
            'id' => Str::random(10),
            'authorId' => Str::random(10),
            'title' => Str::random(10),
            'body' => Str::random(100),
            'latitude' => 39.925620,
            'longitude' => -75.168290
        ]);

        DB::table('posts')->insert([
            'id' => Str::random(10),
            'authorId' => Str::random(10),
            'title' => Str::random(10),
            'body' => Str::random(100),
            'latitude' => 39.981720,
            'longitude' => -75.163520
        ]);

        DB::table('posts')->insert([
            'id' => Str::random(10),
            'authorId' => Str::random(10),
            'title' => Str::random(10),
            'body' => Str::random(100),
            'latitude' => 40.024970,
            'longitude' => -75.220550
        ]);

        DB::table('posts')->insert([
            'id' => Str::random(10),
            'authorId' => Str::random(10),
            'title' => Str::random(10),
            'body' => Str::random(100),
            'latitude' => 37.785834,
            'longitude' => -122.406417
        ]);

        DB::table('posts')->insert([
            'id' => Str::random(10),
            'authorId' => Str::random(10),
            'title' => Str::random(10),
            'body' => Str::random(100),
            'latitude' => 37.785834,
            'longitude' => -122.406417
        ]);

        DB::table('posts')->insert([
            'id' => Str::random(10),
            'authorId' => Str::random(10),
            'title' => Str::random(10),
            'body' => Str::random(100),
            'latitude' => 37.785834,
            'longitude' => -122.406417
        ]);
    }
}
