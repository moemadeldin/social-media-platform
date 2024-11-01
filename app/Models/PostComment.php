<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostComment extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
        'parent_comment_id'
    ];
}
