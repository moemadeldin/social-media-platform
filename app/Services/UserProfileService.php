<?php

namespace App\Services;

use App\Enums\FollowStatus;
use App\Enums\ProfileStatus;
use App\Exceptions\FollowException;
use App\Http\Resources\UserPrivateProfileResource;
use App\Http\Resources\UserProfileResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Services\FollowService;

class UserProfileService
{
    /**
     * Create a new class instance.
     */
    private FollowService $followService;

    public function __construct(FollowService $followService)
    {
        $this->followService = $followService;
    }

     private function getUserByUsername($username)
     {
        return User::where('username', $username)->firstOrFail();
     }
     private function profileStatusChecker($user, $viewer)
     {
        if($user->profile_status == ProfileStatus::PRIVATE->value) {
            if(!$viewer || $viewer->id != $user->id) {
                if(!$viewer || !$viewer->following()->where('user_id', $user->id)->exists()){
                    return new UserPrivateProfileResource($user);
                }
            }
        }
        return new UserProfileResource($user);
     }

     public function viewProfile($username)
     {
        $viewer = auth()->user();

        $user = $this->getUserByUsername($username);
        
        return $this->profileStatusChecker($user, $viewer);
     }

     public function follow($user, $username)
     {
        return DB::transaction(function () use ($user, $username) {
            try {
                $userToFollow = $this->getUserByUsername($username);
                $this->followService->validateFollow($user, $userToFollow);
                if($user->profile_status === ProfileStatus::PRIVATE->value) {
                    $this->followService->createFollowRequest($user, $userToFollow);
                }
                $user->following()->attach($userToFollow->id);
                $user->increment('following_count');
                $userToFollow->increment('followers_count');
                DB::commit();
                return $userToFollow;
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
        });
     }
     public function unfollow($user, $username)
     {
        return DB::transaction(function () use ($user, $username) {
            try {
                $userToUnFollow = $this->getUserByUsername($username);

                $this->followService->validateUnFollow($user, $userToUnFollow);
                $user->following()->detach($userToUnFollow->id);
                $user->decrement('following_count');
                $userToUnFollow->decrement('followers_count');
    
                DB::commit();
                return $userToUnFollow;
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
        });
     }

     public function accept($user, $username)
     {
        return DB::transaction(function () use ($user, $username) {
            try {
                $userToAccept = $this->getUserByUsername($username);
                
                $followRequest = $this->followService->createFollowRequest($user, $userToAccept);

                if(!$followRequest) {
                    throw FollowException::followRequestNotFound();
                }
                $followRequest->update([
                    'status' => FollowStatus::ACCEPTED->value
                ]);
                
                $user->following()->attach($userToAccept->id);
                $user->increment('following_count');
                $userToAccept->increment('followers_count');
                
                DB::commit();
                return $userToAccept;
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
        });
     }

     public function decline($user, $username)
     {
        $followRequest = $this->followService->followRequestFinder($user, $username);

        if($followRequest){
            return $followRequest->delete();
        }
        return throw FollowException::followRequestNotFound();
     }
}
