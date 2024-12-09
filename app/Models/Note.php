<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Note extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'content',
        'likes_count',
        'expires_at'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likable');
    }
    public function media(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable');
    }
}
