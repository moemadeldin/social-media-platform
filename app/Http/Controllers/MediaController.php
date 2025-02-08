<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\MediaRequest;
use App\Models\Media;
use App\Models\User;
use App\Util\APIResponder;
use Illuminate\Http\JsonResponse;

final class MediaController extends Controller
{
    use APIResponder;

    public function store(MediaRequest $request, Media $media): JsonResponse
    {
        $user = auth()->user();

        $postMedia = Media::create(array_merge($request->validated(), ['post_id' => $media->id]));

        if ($postMedia->post->id !== $user->id) {
            return $this->failedResponse('you cannot upload media to this post');
        }

        return $this->successResponse('', 'media uploaded successfully!');

    }

    public function update(MediaRequest $request, $username, Media $postMedia): JsonResponse
    {
        $user = User::where('username', $username)->firstOrFail();

        if ($postMedia->post->id !== $user->id) {
            return $this->failedResponse('you cannot update media to this post');
        }
        $postMedia->update($request->validated());

        return $this->successResponse('', 'media updated successfully!');

    }

    public function destroy($username, Media $media): JsonResponse
    {
        $user = User::where('username', $username)->firstOrFail();

        if ($media->post->id !== $user->id) {
            return $this->failedResponse('you cannot delete media to this post');
        }

        return $this->successResponse('', 'media deleted successfully!');
    }
}
