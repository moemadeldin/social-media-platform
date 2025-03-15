<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

final class Post extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'caption',
        'location',
        'visibility',
        'likes_count',
        'comments_count',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function collaborators(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_collaborator', 'post_id', 'user_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_tag', 'post_id', 'user_id');
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likable');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }

    public function savedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'saved_posts', 'post_id', 'user_id')->withTimestamps();
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
