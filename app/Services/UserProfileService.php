<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class UserProfileService
{
    /**
     * Create a new class instance.
     */

     private function getUserByUsername($username)
     {
        return User::where('username', $username)->firstOrFail();
     }

     private function validateFollow($user, $userToFollow)
     {
        if ($user->id == $userToFollow->id) {
            throw new Exception("You cannot follow yourself");
        }

        if($user->following()->where('user_id', $userToFollow->id)->exists()){
            throw new Exception("You are already following this user");
        }
     }

     private function validateUnFollow($user, $userToUnFollow)
     {
        if($user->id == $userToUnFollow->id) {
            throw new Exception("You cannot unfollow yourself");
        }
        if(!$user->following()->where('user_id', $userToUnFollow->id)->exists()){
            throw new Exception("You are not following this user");
        }
     }
     public function viewProfile($username)
     {
        return $this->getUserByUsername($username);
     }

     public function follow($user, $username)
     {
        return DB::transaction(function () use ($user, $username) {
            try {
                $userToFollow = $this->getUserByUsername($username);
                $this->validateFollow($user, $userToFollow);
                
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

                $this->validateUnFollow($user, $userToUnFollow);
        
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
}
