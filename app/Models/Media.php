<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Media extends Model
{
    use HasUuids, SoftDeletes;

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
