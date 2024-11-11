<?php

namespace App\Services;

use App\Enums\UserStatus;
use App\Events\UserVerificationRequested;
use App\Exceptions\PasswordException;
use App\Exceptions\UserStatusException;
use App\Models\User;
use App\Notifications\PasswordChangedNotification;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Create a new class instance.
     */
    private function generateAccessToken(User $user)
    {
        return $user->createToken('Personal Access Token')->plainTextToken;
    }

    private function deleteAccessTokens(User $user)
    {
        $user->tokens()->delete();
    }

    private function findUserByEmail($email = null, $username = null, $mobile = null)
    {
         return User::where('email', $email)
                ->orWhere('username', $username)
                ->orWhere('mobile', $mobile)
                ->firstOrFail();
    }

    private function validateUserCredentials($data)
    {

        $user = $this->findUserByEmail($data['email'] ?? null, $data['username'] ?? null, $data['mobile'] ?? null);

        if (! Hash::check($data['password'], $user->password)) {
            throw PasswordException::incorrect();
        }

        $this->ensureUserIsActive($user);

        return $user;
    }

    private function findUserByEmailAndOTP($data)
    {
        return isset($data['email'])
        ? User::where('email', $data['email'])
            ->where('verification_code', $data['code'])
            ->firstOrFail()
        : User::where('mobile', $data['mobile'])
            ->where('verification_code', $data['code'])
            ->firstOrFail();
    }

    private function ensureUserIsActive(User $user)
    {
        if ($user->status != UserStatus::ACTIVE->value) {
            throw UserStatusException::notActiveOrBlocked();
        }
    }

    private function respondWithUserAndToken(User $user)
    {
        return [
            'user' => $user,
            'access_token' => $this->generateAccessToken($user),
        ];
    }

    public function register($data)
    {
        $user = User::create($data);

        event(new UserVerificationRequested($user));

        return $this->respondWithUserAndToken($user);
    }

    public function verify($data)
    {
        $user = $this->findUserByEmailAndOTP($data);

        $user->update([
            'status' => UserStatus::ACTIVE->value,
            'verification_code' => null,
        ]);

        return $this->respondWithUserAndToken($user);
    }

    public function login($data)
    {
        return $this->respondWithUserAndToken(
            $this->validateUserCredentials(
                $data
            ));
    }

    public function forgetPassword($data)
    {
        $user = $this->findUserByEmail($data['email'] ?? null, $data['username'] ?? null, $data['mobile'] ?? null);

        event(new UserVerificationRequested($user));

        return $user;
    }

    public function checkOTP($data)
    {
        return $this->respondWithUserAndToken(
            $this->findUserByEmailAndOTP(
                $data)
        );
    }

    public function resetPassword($data, $user)
    {

        if (Hash::check($data['password'], $user->password)) {
            throw PasswordException::sameAsCurrent();
        }

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        $this->deleteAccessTokens($user);

        $user->notify(new PasswordChangedNotification(config('app.admin_email')));

        return $user;
    }

    public function logout($user)
    {
        return $this->deleteAccessTokens($user);
    }
}