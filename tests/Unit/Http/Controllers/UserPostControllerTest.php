<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\UserPostController;
use App\Http\Requests\PostRequestForm;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase as TestsTestCase;

class UserPostControllerTest extends TestsTestCase
{
    use DatabaseMigrations;

    public function test_index()
    {
        $response = $this->get('/');
        $response->assertViewHas('posts');
        $response->assertStatus(200);
    }

    // public function test_users_can_create_posts()
    // {
    //     $user = User::factory()->create();
    //     $this->actingAs($user);

    //     $request = $this->createMock(PostRequestForm::class);

    //     $request->expects($this->once())->method('validated')->willReturn([
    //         'user_id' => Auth::id(),
    //         'slug' => 'Slug tesssst',
    //         'title' => 'title test',
    //         'thumbnail' => UploadedFile::fake()->create('testImage.jpg', 1024),
    //         'excerpt' => 'excerpt test',
    //         'body' => 'body test',
    //         'status' => Post::PENDING_POST_STATUS
    //     ]);

    //     (new UserPostController())->store($request);

    //     $post = Post::first();

    //     $this->assertEquals(1, Post::count());

    //     $this->assertEquals($user->id, $post->author->id);
    //     $this->assertEquals('Slug tesssst', $post->slug);
    //     $this->assertEquals('title test', $post->title);
    //     $this->assertEquals('excerpt test', $post->excerpt);
    //     $this->assertEquals('body test', $post->body);
    //     $this->assertInstanceOf(User::class, $post->author);
    // }
}