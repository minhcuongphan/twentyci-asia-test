<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'slug', 'title', 'thumbnail', 'excerpt', 'body', 'status'];

    protected $with = ['author'];

    const PENDING_POST_STATUS = 1;

    const APPROVED_POST_STATUS = 2;

    /**
     * Scope a query to only include particular posts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param boolean $isApprovedStatusFilter
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeOfPostFilter($query, array $filters, $isApprovedStatusFilter)
    {
        $query->when(
            $filters['search'] ?? false,
            fn ($query, $search) =>
            $query->where(
                fn ($query) =>
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%')
            )
        );

        $query->when(
            $filters['author'] ?? false,
            fn ($query, $author) =>
            $query->whereHas(
                'author',
                fn ($query) =>
                $query->where('username', $author)
            )
        );

        $query->when(
            ($filters['status'] ?? false) == self::PENDING_POST_STATUS,
            fn ($query) =>
            $query->whereStatus(self::PENDING_POST_STATUS)
        );

        $query->when(
            ($filters['status'] ?? false) == self::APPROVED_POST_STATUS,
            fn ($query) =>
            $query->whereStatus(self::APPROVED_POST_STATUS)
        );

        $query->when(
            empty($filters['order_by']),
            fn ($query) =>
           $query->orderBy('created_at', 'asc')
        );

        $query->when(
            !empty($filters['order_by']),
            fn ($query) =>
            $query->orderBy('created_at', 'desc')
        );

        $query->when(
            $isApprovedStatusFilter,
            fn ($query) =>
            $query->whereStatus(self::APPROVED_POST_STATUS)
        );
    }

    /**
     * One post has one author
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}