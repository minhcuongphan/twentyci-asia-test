<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequestForm;
use App\Models\Post;
use App\Repositories\PostRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class BaseAdminPostController extends Controller
{
    /**
     * @var PostRepository
     */
    protected $repository = null;

    public function __construct(PostRepository $repository) {
        $this->repository = $repository;
    }

    public function index()
    {
        try {
            $posts = $this->repository->getAllPosts(request(['status', 'order_by']), false);
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->withError($exception->getMessage())->withInput();
        }

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(PostRequestForm $request)
    {
        try {
            $this->repository->createNewPost($request, false);
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->withError($exception->getMessage())->withInput();
        }

        return redirect('/');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', ['post' => $post]);
    }

    public function update(PostRequestForm $request, Post $post)
    {
        try {
            $this->repository->updatePost($request, $post);
            return back()->with('success', 'Post Updated!');
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    public function destroy(Post $post)
    {
        try {
            $this->repository->delete($post->id);
            return back()->with('success', 'Post Deleted!');
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->withError($exception->getMessage())->withInput();
        }
    }
}
