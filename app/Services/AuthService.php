<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserStatus;
use App\Events\UserVerificationRequested;
use App\Exceptions\PasswordException;
use App\Exceptions\UserStatusException;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\VerifyRequest;
use App\Models\User;
use App\Notifications\PasswordChangedNotification;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;

final class AuthService
{
    public function __construct(
        private readonly AuthRepository $authRepository,
        private readonly TokenManager $tokenManager
    ){}
    public function register(array $data): array
    {
        $user = $this->authRepository->create($data);

        event(new UserVerificationRequested($user));

        return $this->tokenManager->respondWithUserAndToken($user);
    }

    public function verify(array $data): array
    {
        $user = $this->authRepository->findUserByEmailOrMobileWithCode($data);

        $user->update([
            'status' => UserStatus::ACTIVE->value,
            'verification_code' => null,
        ]);
        
        return $this->tokenManager->respondWithUserAndToken($user);
    }

    // public function login(LoginRequest $request)
    // {
    //     return $this->tokenManager->respondWithUserAndToken(
    //         $this->validateUserCredentials(
    //             $request->validated()
    //         ));
    // }

    // public function forgetPassword(ForgetPasswordRequest $request)
    // {
    //     $user = $this->findUserByEmailOrMobileOrUsername($request);

    //     event(new UserVerificationRequested($user));

    //     return $user;
    // }

    // public function checkOTP(VerifyRequest $request)
    // {
    //     return $this->respondWithUserAndToken(
    //         $this->verifyUserByEmailOrMobile(
    //             $request)
    //     );
    // }

    // public function resetPassword($data, $user)
    // {

    //     if (Hash::check($data['password'], $user->password)) {
    //         throw PasswordException::sameAsCurrent();
    //     }

    //     $user->update([
    //         'password' => Hash::make($data['password']),
    //     ]);

    //     $this->deleteAccessTokens($user);

    //     $user->notify(new PasswordChangedNotification(config('app.admin_email')));

    //     return $user;
    // }

    // public function logout(User $user): void
    // {
    //     return $this->tokenManager->deleteAccessTokens($user);
    // }

    /**
     * Create a new class instance.
     */


    // private function findUserByEmailOrMobileOrUsername(ForgetPasswordRequest $request)
    // {
    //     return User::where(function ($query) use ($request) {
    //         $query->where('mobile', $request['mobile'])
    //             ->orWhere('username', $request['username'])
    //             ->orWhere('email', $request['email']);
    //     })->firstOrFail();
    // }

    // private function validateUserCredentials($data)
    // {

    //     $user = $this->findUserByEmailOrMobileOrUsername($data['email'] ?? null, $data['username'] ?? null, $data['mobile'] ?? null);

    //     if (! Hash::check($data['password'], $user->password)) {
    //         throw PasswordException::incorrect();
    //     }

    //     $this->ensureUserIsActive($user);

    //     return $user;
    // }

    // private function verifyUserByEmailOrMobile(VerifyRequest $request)
    // {
    //     return User::where(function ($query) use ($request) {
    //         $query->where('email', $request['email_or_mobile'])
    //             ->orWhere('mobile', $request['email_or_mobile']);
    //     })
    //         ->where('verification_code', $request['code'])
    //         ->firstOrFail();
    // }

    // private function ensureUserIsActive(User $user)
    // {
    //     if ($user->status !== UserStatus::ACTIVE->value) {
    //         throw UserStatusException::notActiveOrBlocked();
    //     }
    // }
}
