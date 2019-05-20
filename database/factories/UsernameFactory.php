<?php

use Faker\Generator as Faker;

$factory->define(\App\Username::class, function (Faker $faker) {
    return [
        'username' => $faker->userName
    ];
});

$factory->afterCreating(\App\Post::class, function ($post, $faker) {
    $post->username()->save(factory(\App\Username::class)->create([
        'usernameable_id' => $post->id,
        'usernameable_type' => \App\Post::class
    ]));
});

$factory->afterCreating(\App\Comment::class, function ($comment, $faker) {
    $comment->username()->save(factory(\App\Username::class)->create([
        'usernameable_id' => $comment->id,
        'usernameable_type' => \App\Comment::class
    ]));
});