<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStoryRequest;
use App\Http\Resources\StoryResource;
use App\Models\Story;
use App\Models\User;
use App\Util\APIResponder;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class StoryController extends Controller
{
    use APIResponder;
    /**
     * Display a listing of the resource.
     */
    public function index($username): JsonResponse
    {
        $user = User::where('username', $username)->firstOrFail();
        
        $stories = $user->stories()->orderBy('created_at', 'desc')->get();

        return $this->successResponse(StoryResource::collection($stories), 'Stories');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateStoryRequest $request)
    {
        $user = auth()->user();
        $story = Story::create(array_merge($request->validated(), [
            'user_id' => $user->id,
            'expires_at' => Carbon::now()->addHours(24),
        ]));
        return $this->successResponse($story, 'Story has been added successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($username, $id)
    {
        $user = auth()->user();

        $story = Story::findOrFail($id);

        $story->delete();

        return $this->successResponse($story, 'story has been deleted');
    }
}
