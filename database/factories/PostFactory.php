<?php

use Faker\Generator as Faker;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

$factory->define(\App\Post::class, function (Faker $faker) {
    $random = rand(1, 59);

    return [
        'id' => Uuid::uuid4()->toString(),
        'author_id' => Uuid::uuid4()->toString(),
        'title' => $faker->text(20),
        'body' => $faker->text(100),
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'created_at' => Carbon::now()->subMinutes($random),
        'updated_at' => Carbon::now()->subMinutes($random)
    ];
});

$factory->state(\App\Post::class, 'withComments', []);

$factory->state(\App\Post::class, 'old', [
    'created_at' => Carbon::now()->subHour(2),
    'updated_at' => Carbon::now()->subHour(2)
]);

$factory->state(\App\Post::class, 'oldWithComments', [
    'created_at' => Carbon::now()->subHour(2),
    'updated_at' => Carbon::now()->subHour(2)
]);
