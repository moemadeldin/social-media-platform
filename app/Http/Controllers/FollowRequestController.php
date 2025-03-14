<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\FollowRequestsResource;
use App\Services\FollowService;
use App\Services\UserProfileService;
use App\Util\APIResponder;
use Illuminate\Http\JsonResponse;

final class FollowRequestController extends Controller
{
    use APIResponder;

    private UserProfileService $userProfileService;

    private FollowService $followService;

    public function __construct(UserProfileService $userProfileService, FollowService $followService)
    {
        $this->userProfileService = $userProfileService;
        $this->followService = $followService;
    }

    public function pendingFollowRequests(): JsonResponse
    {
        $user = auth()->user();

        $pendingRequests = $this->userProfileService->getPendingRequests($user);

        return $this->successResponse(FollowRequestsResource::collection($pendingRequests), 'Pending requests fetched');
    }

    public function store($username)
    {
        $userToAccept = $this->userProfileService->accept(auth()->user(), $username);

        return $this->successResponse($userToAccept, 'Request Accepted successfully');
    }

    public function destroy($username)
    {
        $userToDecline = $this->userProfileService->decline(auth()->user(), $username);

        return $this->successResponse($userToDecline, 'Request Declined successfully');
    }
}
