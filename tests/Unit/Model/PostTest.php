<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2019-05-19
 * Time: 23:14
 */

namespace Tests\Unit\Model;


use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        factory(Post::class, 5)->states('old')->create();

        factory(Post::class, 5)->states('oldWithComments')->create();
    }

    public function testCleanupPosts() {
        $this->assertEquals(10, Post::count());

        (new Post())->cleanupPosts();

        $this->assertEquals(0, Post::count());
    }
}