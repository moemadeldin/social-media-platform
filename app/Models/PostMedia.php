<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostMedia extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'post_id',
        'media_path',
        'media_type',
        'order',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
