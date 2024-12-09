<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
        'likes_count',
        'replies_count',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likable');
    }
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
