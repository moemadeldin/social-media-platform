<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\LikeService;
use App\Util\APIResponder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

final class LikeController extends Controller
{
    use APIResponder;
    public function __construct(private readonly LikeService $likeService) {}
    public function store(Model|string $model, string|int $id): JsonResponse
    {
        $like = $this->likeService->toggleLike(auth()->user(), $model, $id);

        $message = $like->wasRecentlyCreated ? 'Liked successfully' : 'Unliked successfully';

        return $this->successResponse($like, $message);
    }
}
