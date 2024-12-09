<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'media_path',
        'media_type',
        'order',
    ];

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}
