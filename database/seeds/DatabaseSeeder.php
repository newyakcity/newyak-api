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
            'author_id' => Str::random(10),
            'title' => Str::random(10),
            'body' => Str::random(100),
            'latitude' => 39.925620,
            'longitude' => -75.168290,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('posts')->insert([
            'id' => Str::random(10),
            'author_id' => Str::random(10),
            'title' => Str::random(10),
            'body' => Str::random(100),
            'latitude' => 39.981720,
            'longitude' => -75.163520,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('posts')->insert([
            'id' => Str::random(10),
            'author_id' => Str::random(10),
            'title' => Str::random(10),
            'body' => Str::random(100),
            'latitude' => 40.024970,
            'longitude' => -75.220550,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('posts')->insert([
            'id' => Str::random(10),
            'author_id' => Str::random(10),
            'title' => Str::random(10),
            'body' => Str::random(100),
            'latitude' => 37.785834,
            'longitude' => -122.406417,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('posts')->insert([
            'id' => Str::random(10),
            'author_id' => Str::random(10),
            'title' => Str::random(10),
            'body' => Str::random(100),
            'latitude' => 37.785834,
            'longitude' => -122.406417,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('posts')->insert([
            'id' => Str::random(10),
            'author_id' => Str::random(10),
            'title' => Str::random(10),
            'body' => Str::random(100),
            'latitude' => 37.785834,
            'longitude' => -122.406417,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
