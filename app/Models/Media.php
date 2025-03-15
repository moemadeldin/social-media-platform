<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final class Media extends Model
{
    use HasUuids;

    protected $fillable = [
        'path',
        'type',
        'order',
    ];

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}
