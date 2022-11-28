<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Errors\ErrorCodes;
use App\Http\Requests\Auth\AuthenticateUserRequest;
use App\Http\Requests\Auth\LogoutUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * @param \App\Http\Requests\Auth\RegisterUserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $request->only('name', 'email', 'password', 'document_number', 'phone_number');

        $user = User::create([
            'name' => $request->name,
            'document_number' => $request->document_number,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password)
        ]);
        $credentials = $request->only('email', 'password');

        return response()->json([
            'success' => true,
            'cod_error' => ErrorCodes::WITHOUT_ERROR,
            'message_error' => null,
            'token' => JWTAuth::attempt($credentials),
            'data' => [
                'message' => 'User created successfully',
                'user' => $user
            ]
        ], Response::HTTP_OK);
    }


    /**
     * @param \App\Http\Requests\Auth\RegisterUserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(AuthenticateUserRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'cod_error' => (new ErrorCodes())->getAuthenticationErrorCode('LOGIN_FAILED'),
                    'message_error' => 'Login failed',
                ], Response::HTTP_UNAUTHORIZED);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'cod_error' => (new ErrorCodes())->getAuthenticationErrorCode('AUTHENTICATION_ERROR_UNKNOWN'),
                'message' => 'Has error occurred while authenticating',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'success' => true,
            'cod_error' => ErrorCodes::WITHOUT_ERROR,
            'message_error' => null,
            'token' => $token,
            'data' => [
                'message' => 'User authenticate successfully',
                'user' => Auth::user()
            ]
        ]);
    }


    /**
     * @param \App\Http\Requests\Auth\LogoutUserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(LogoutUserRequest $request): JsonResponse
    {
        try {
            JWTAuth::invalidate($request->token);
            return response()->json([
                'success' => true,
                'cod_error' => ErrorCodes::WITHOUT_ERROR,
                'message_error' => null,
                'data' => [
                    'message' => 'User disconnected'
                ]
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'cod_error' => (new ErrorCodes())->getAuthenticationErrorCode('AUTHENTICATION_ERROR_UNKNOWN'),
                'message' => 'Has error occurred while logout',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getUser(Request $request): JsonResponse
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $user = JWTAuth::authenticate($request->token);

        if (!$user) {
            return response()->json([
                'success' => false,
                'cod_error' => (new ErrorCodes())->getAuthenticationErrorCode('INVALID_USER_TOKEN'),
                'message' => 'Invalid token / token expired',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json(['user' => $user]);
    }
}
