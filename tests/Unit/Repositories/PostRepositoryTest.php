<?php

namespace Tests\Unit\Repositories;

use App\Http\Requests\PostRequestForm;
use App\Models\Post;
use App\Models\User;
use App\Repositories\PostRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase as TestsTestCase;


class PostRepositoryTest extends TestsTestCase
{
    use DatabaseMigrations;

    /**
     * test get model
     *
     * @return void
     */
    public function testGetModel()
    {
        $postRepository = new PostRepository;

        $data = $postRepository->getModel();
        $this->assertEquals(Post::class, $data);
    }

    public function test_users_can_create_new_posts()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $request = $this->createMock(PostRequestForm::class);

        $request->expects($this->once())->method('validated')->willReturn([
            'user_id' => Auth::id(),
            'slug' => 'Slug tesssst',
            'title' => 'title test',
            'thumbnail' => UploadedFile::fake()->create('testImage.jpg', 1024),
            'excerpt' => 'excerpt test',
            'body' => 'body test',
            'status' => Post::PENDING_POST_STATUS
        ]);

        (new PostRepository)->createNewPost($request, true);

        $post = Post::first();

        $this->assertEquals(1, Post::count());

        $this->assertEquals($user->id, $post->author->id);
        $this->assertEquals('Slug tesssst', $post->slug);
        $this->assertEquals('title test', $post->title);
        $this->assertEquals('excerpt test', $post->excerpt);
        $this->assertEquals('body test', $post->body);
        $this->assertInstanceOf(User::class, $post->author);
    }
}