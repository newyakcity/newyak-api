<?php

use Faker\Generator as Faker;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

$factory->define(\App\Comment::class, function (Faker $faker) {
    $random = rand(1, 59);

    return [
        'id' => Uuid::uuid4()->toString(),
        'author_id' => Uuid::uuid4()->toString(),
        'body' => $faker->text(100),
        'created_at' => Carbon::now()->subMinutes($random),
        'updated_at' => Carbon::now()->subMinutes($random)
    ];
});

$factory->state(\App\Comment::class, 'old', [
    'created_at' => Carbon::now()->subHours(2),
    'updated_at' => Carbon::now()->subHours(2)
]);

$factory->afterCreatingState(\App\Post::class, 'withComments', function ($post, $faker) {
    $random = rand(1, 59);

    factory(\App\Comment::class, $random)->create([
        'postId' => $post->id
    ]);
});

$factory->afterCreatingState(\App\Post::class, 'oldWithComments', function ($post, $faker) {
    $random = rand(1, 59);
    factory(\App\Comment::class, $random)->states('old')->create([
        'postId' => $post->id
    ]);
});