<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateStoryRequest;
use App\Http\Resources\StoryResource;
use App\Models\Story;
use App\Models\User;
use App\Util\APIResponder;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

final class StoryController extends Controller
{
    use APIResponder;

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = auth()->user();

        $stories = $user->stories()->orderBy('created_at', 'desc')->get();

        return $this->successResponse(StoryResource::collection($stories), 'Stories');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateStoryRequest $request): JsonResponse
    {
        $user = auth()->user();

        $story = $user->stories()->create([
            'content' => $request->safe()->content,
            'expires_at' => Carbon::now()->addHours(User::DEFAULT_EXPIRE_DATE)
        ]);

        return $this->successResponse($story, 'Story has been added successfully!');
    }
    public function update(CreateStoryRequest $request, User $user, Story $story): JsonResponse
    {
        $story->update($request->validated());

        return $this->successResponse($story, 'Story has been updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Story $story): JsonResponse
    {
        $user = User::where('username', $user->username)->firstOrFail();

        $story->delete();

        return $this->successResponse($story, 'story has been deleted');
    }
}
