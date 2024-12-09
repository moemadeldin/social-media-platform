<?php

namespace App\Http\Controllers;


use App\Services\LikeService;
use App\Util\APIResponder;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
    private LikeService $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }
    use APIResponder;
    public function store($model, $id): JsonResponse
    {
        $like = $this->likeService->toggleLike(auth()->user(), $model, $id);

        $message = $like->wasRecentlyCreated ? 'Liked successfully' : 'Unliked successfully';

        return $this->successResponse($like, $message);

    }
}
