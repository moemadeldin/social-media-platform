<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserProfileResource;
use App\Services\UserProfileService;
use App\Util\APIResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    use APIResponder;

    private UserProfileService $userProfileService;

    public function __construct(UserProfileService $userProfileService)
    {
        $this->userProfileService = $userProfileService;
    }
    public function index(Request $request): JsonResponse
    {
        return $this->successResponse(
            $this->userProfileService->viewProfile(
                $request->username), 
                    'Profile');
    }

    public function store(Request $request): JsonResponse
    {
        return $this->successResponse(new UserProfileResource(
            $this->userProfileService->follow(
                auth()->user(), 
                    $request->username)),
                        'You followed this user successfully!');
    }
    public function destroy(Request $request): JsonResponse
    {
        return $this->successResponse(new UserProfileResource(
            $this->userProfileService->unfollow(
                auth()->user(),
                    $request->username)),
                        'You unfollowed this user successfully!');
    }
}
