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

$factory->state(\App\Comment::class, 'withComments', []);

$factory->afterCreatingState(\App\Post::class, 'withComments', function ($post, $faker) {
    $random = rand(1, 59);

    factory(\App\Comment::class, $random)->create([
        'commentable_id' => $post->id,
        'commentable_type' => \App\Post::class
    ]);
});

$factory->afterCreatingState(\App\Post::class, 'oldWithComments', function ($post, $faker) {
    $random = rand(1, 59);
    factory(\App\Comment::class, $random)->states('old')->create([
        'commentable_id' => $post->id,
        'commentable_type' => \App\Post::class
    ]);
});

$factory->afterCreatingState(\App\Post::class, 'withNestedComments', function ($post, $faker) {
    $random = rand(1, 59);
    factory(\App\Comment::class, $random)->states('withComments')->create([
        'commentable_id' => $post->id,
        'commentable_type' => \App\Post::class
    ]);
});

$factory->afterCreatingState(\App\Comment::class, 'withComments', function ($comment, $faker) {
    $random = rand(1, 59);
    factory(\App\Comment::class, $random)->create([
        'commentable_id' => $comment->id,
        'commentable_type' => \App\Comment::class
    ]);
});