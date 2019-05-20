<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2019-05-20
 * Time: 01:41
 */

namespace Tests\Unit\Model;


use App\Comment;
use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        factory(Post::class)->states('withNestedComments')->create();
    }

    function testGetNestedComments() {
        $hasNested = Comment::with('comments')->count();

        $this->assertTrue($hasNested > 0);
    }
}