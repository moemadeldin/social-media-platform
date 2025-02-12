<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserStatus;
use App\Events\UserVerificationRequested;
use App\Exceptions\PasswordException;
use App\Exceptions\UserStatusException;
use App\Models\User;
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

    public function login(array $data): array
    {
        return $this->tokenManager->respondWithUserAndToken(
            $this->validateUserCredentials(
                $data
            )
        );
    }
    public function logout(User $user): void
    {
        $this->tokenManager->deleteAccessToken($user);
    }

    private function validateUserCredentials(array $data): User
    {

        $user = $this->authRepository->findUserByEmailOrMobileOrUsername($data);

        $this->validatePassword($user, $data);

        $this->ensureUserIsActive($user);

        return $user;
    }
    private function validatePassword(User $user, array $data): void
    {
        if (! Hash::check($data['password'], $user->password)) 
        {
            throw PasswordException::incorrect();
        }
    }
    private function ensureUserIsActive(User $user): void
    {
        if ($user->status !== UserStatus::ACTIVE->value) {
            throw UserStatusException::notActiveOrBlocked();
        }
    }

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
}
