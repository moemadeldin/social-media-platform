<?php


declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'profile_picture',
        'gender',
        'bio',
        'website',
        'mobile',
        'profile_status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
