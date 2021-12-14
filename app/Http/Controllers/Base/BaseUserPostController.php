<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequestForm;
use App\Models\Post;
use App\Repositories\PostRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BaseUserPostController extends Controller
{
    /**
     * @var Request
     */
    protected $request = null;

    /**
     * @var PostRepository
     */
    protected $repository = null;

    public function __construct(Request $request, PostRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;
    }

    public function index()
    {
        try {
            $posts = $this->repository->getAllPosts(request(['search', 'author']), true);
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->withError($exception->getMessage())->withInput();
        }

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('users.posts.create');
    }

    public function store(PostRequestForm $request)
    {
        try {
            $this->repository->createNewPost($request, true);
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->withError($exception->getMessage())->withInput();
        }

        return redirect(route('user-posts'));
    }

    public function showAllMyPosts()
    {
        try {
            $posts = $this->repository->showAllMyPosts();
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->withError($exception->getMessage())->withInput();
        }

        return view('users.posts.index', compact('posts'));
    }

    public function edit(Post $post)
    {
        return view('users.posts.edit', compact('post'));
    }

    public function update(PostRequestForm $request, Post $post)
    {
        try {
            $this->repository->updatePost($post, $request);
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