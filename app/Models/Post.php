<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes, HasUuids;


    protected $fillable = [
        'user_id',
        'caption',
        'location',
        'visibility',
        'comments_count',
        'likes_count'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function collaborators(): belongsToMany
    {
        return $this->belongsToMany(User::class, 'post_collaborator', 'post_id', 'user_id');
    }
    public function tags(): belongsToMany
    {
        return $this->belongsToMany(User::class, 'post_tag', 'post_id', 'user_id');
    }
    public function likes(): HasMany
    {
        return $this->hasMany(PostLike::class);
    }
    public function comments(): HasMany
    {
        return $this->hasMany(PostComment::class);
    }
    public function savedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'saved_posts', 'post_id', 'user_id')->withTimestamps();
    }
    public function postMedia(): HasMany
    {
        return $this->hasMany(PostMedia::class);
    }
}
