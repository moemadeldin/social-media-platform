<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class UserProfile extends Model
{
    use HasUuids;

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'profile_picture',
        'gender',
        'bio',
        'website',
        'profile_status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
