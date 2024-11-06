<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Util\APIResponder;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    use APIResponder;
    public function register(CreateUserRequest $request): JsonResponse
    {
        $user = User::create(attributes: $request->validated());

        $user->access_token = $user->createToken("Personal Access Token")->plainTextToken;

        return $this->successResponse($user, "User Registered Successfully!");
    }
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)
                ->orWhere('username', $request->username)
                ->orWhere('mobile', $request->mobile)
                ->first();
        if(! Hash::check($request->password, $user->password)){
            return $this->failedResponse(throw new Exception("credientals are failed"));
        }
        return $this->successResponse($user,"Logged in");
    }
}
