<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\FollowStatus;
use App\Exceptions\FollowException;
use App\Models\Follower;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

final class FollowService
{
    /**
     * Create a new class instance.
     */
    public function followRequestFinder(User $user, User $userToFollow): ?Follower
    {
        return Follower::where('user_id', $userToFollow->id)
            ->where('follower_id', $user->id)
            ->where('status', FollowStatus::PENDING->value)
            ->first();
    }

    public function getPendingFollowRequests(User $user): Collection
    {
        return Follower::where('user_id', $user->id)
            ->where('status', FollowStatus::PENDING->value)
            ->get();
    }

    public function createFollowRequest(User $user, User $userToFollow): Follower
    {
        $existingRequest = $this->followRequestFinder($user, $userToFollow);

        if (! $existingRequest) {
            return Follower::create([
                'user_id' => $userToFollow->id,
                'follower_id' => $user->id,
                'status' => FollowStatus::PENDING->value,
            ]);
        }

        return $existingRequest;
    }

    public function cancelFollowRequest(User $user, User $userToCancelFollow): ?Follower
    {
        $existingRequest = $this->followRequestFinder($user, $userToCancelFollow);

        if ($existingRequest) {
            $existingRequest->delete();
        }

        return $existingRequest;
    }

    public function acceptFollowRequest(User $user, User $userToAccept): bool
    {
        $followRequest = $this->followRequestFinder($user, $userToAccept);

        if ($followRequest) {
            $followRequest->update(['status' => FollowStatus::ACCEPTED->value]);

            return true;
        }

        return false;
    }

    public function declineFollowRequest(User $user, User $userToDecline): bool
    {
        $followRequest = $this->followRequestFinder($user, $userToDecline);

        if ($followRequest) {
            return $followRequest->delete();
        }

        return false;
    }

    public function validateFollow(User $user, User $userToFollow): void
    {
        if ($user->id === $userToFollow->id) {
            throw FollowException::selfFollow();
        }

        if ($user->following()->where('user_id', $userToFollow->id)->exists()) {
            throw FollowException::alreadyFollowed();
        }
    }

    public function validateUnFollow(User $user, User $userToUnFollow): void
    {
        if ($user->id === $userToUnFollow->id) {
            throw FollowException::selfUnFollow();
        }
        if (! $user->following()->where('user_id', $userToUnFollow->id)->exists()) {
            throw FollowException::notFollowing();
        }
    }
}
