<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostComment extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
        'parent_comment_id'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    public function parentComment(): BelongsTo
    {
        return $this->belongsTo(PostComment::class);
    }
    public function replies(): HasMany
    {
        return $this->hasMany(PostComment::class);
    }
    public function likes(): HasMany
    {
        return $this->hasMany(CommentLike::class);
    }
}
