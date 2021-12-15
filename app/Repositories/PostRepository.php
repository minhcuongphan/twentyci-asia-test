<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository extends BaseRepository
{
    /**
     * get model
     */
    public function getModel()
    {
        return Post::class;
    }

    /**
     * @param $request
     * @param boolean $isApprovedStatusFilter
     * @return mixed
     */
    public function getAllPosts($request, $isApprovedStatusFilter)
    {
        return $this->model->select("*")
                    ->OfPostFilter($request, $isApprovedStatusFilter)
                    ->paginate(6)
                    ->withQueryString();
    }

    /**
     * @param $request
     * @param boolean $defaultStatus
     * @return mixed
     */
    public function createNewPost($request, $defaultStatus)
    {
        $this->create(array_merge($request->validated(), [
                'user_id' => auth()->user()->id,
                'thumbnail' => request()->file('thumbnail')
                                ? request()->file('thumbnail')->store('thumbnails')
                                : null,
                'status' => $defaultStatus
                            ? Post::PENDING_POST_STATUS
                            : $request->status
        ]));
    }

    /**
     * @param $request
     * @param $post
     * @return mixed
     */
    public function updatePost($request, $post)
    {
        $thumbnail = !empty($request->file('thumbnail'))
                ? $request->file('thumbnail')->store('thumbnails')
                : $post->thumbnail;

        $this->update($post->id, array_merge($request->validated(), [
                'user_id' => auth()->user()->id,
                'thumbnail' => $thumbnail
        ]));
    }

    /**
     * show all posts of a particular user
     */
    public function showAllMyPosts()
    {
        return $this->model->where('user_id', auth()->user()->id)
                            ->paginate(6)
                            ->withQueryString();
    }
}
