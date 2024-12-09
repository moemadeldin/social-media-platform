<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Reply extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'post_id',
        'comment_id',
        'reply',
        'likes_count',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likable');
    }
}
