<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\LikeService;
use App\Util\APIResponder;
use Illuminate\Http\JsonResponse;

final class LikeController extends Controller
{
    use APIResponder;

    private LikeService $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    public function store($model, $id): JsonResponse
    {
        $like = $this->likeService->toggleLike(auth()->user(), $model, $id);

        $message = $like->wasRecentlyCreated ? 'Liked successfully' : 'Unliked successfully';

        return $this->successResponse($like, $message);

    }
}
