<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostMediaRequest;
use App\Models\PostMedia;
use App\Models\User;
use App\Util\APIResponder;
use Illuminate\Http\JsonResponse;

class PostMediaController extends Controller
{
    use APIResponder;
    public function store(PostMediaRequest $request, PostMedia $postMedia): JsonResponse
    {
        $user = auth()->user();

        $postMedia = PostMedia::create(array_merge($request->validated(), ['post_id' => $postMedia->id]));

        if($postMedia->post->id != $user->id){
            return $this->failedResponse('you cannot upload media to this post');
        }

        return $this->successResponse('', 'media uploaded successfully!');

    }
    public function update(PostMediaRequest $request, $username, PostMedia $postMedia): JsonResponse
    {
        $user = User::where('username', $username)->firstOrFail();

        if($postMedia->post->id != $user->id){
            return $this->failedResponse('you cannot update media to this post');
        }
        $postMedia->update($request->validated());

        return $this->successResponse('', 'media updated successfully!');

    }
    public function destroy($username, PostMedia $postMedia): JsonResponse
    {
        $user = User::where('username', $username)->firstOrFail();

        if($postMedia->post->id != $user->id){
            return $this->failedResponse('you cannot delete media to this post');
        }
        return $this->successResponse('', 'media deleted successfully!');
    }
}
