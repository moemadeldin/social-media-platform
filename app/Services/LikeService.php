<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ModelException;
use App\Models\Comment;
use App\Models\Note;
use App\Models\Post;
use App\Models\Reply;
use App\Models\Story;
use App\Util\APIResponder;

final class LikeService
{
    use APIResponder;

    public function toggleLike($user, $model, $id)
    {
        $modelClass = $this->getModelClass($model);

        $model = $modelClass::findOrFail($id);

        $existingLike = $model->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();

            $this->decrementLikesCount($model);

            return $existingLike;
        }

        $like = $model->likes()->create(['user_id' => $user->id]);

        $this->incrementLikesCount($model);

        return $like;
    }

    /**
     * Create a new class instance.
     */
    private function incrementLikesCount($model)
    {

        if ($model instanceof Post ||
            $model instanceof Comment ||
            $model instanceof Reply ||
            $model instanceof Story ||
            $model instanceof Note
        ) {
            $model->increment('likes_count');
        }
    }

    private function decrementLikesCount($model)
    {
        if ($model instanceof Post ||
            $model instanceof Comment ||
            $model instanceof Reply ||
            $model instanceof Story ||
            $model instanceof Note
        ) {
            $model->decrement('likes_count');
        }
    }

    private function getModelClass($model)
    {
        $modelClasses = [
            'post' => Post::class,
            'comment' => Comment::class,
            'reply' => Reply::class,
            'story' => Story::class,
            'note' => Note::class,
        ];

        if (! isset($modelClasses[$model])) {
            throw ModelException::modelIsNotFound();
        }

        return $modelClasses[$model];
    }
}
