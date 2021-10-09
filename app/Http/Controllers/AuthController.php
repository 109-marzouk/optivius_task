<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register', 'login']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'bail|required|json',
            'phone' => 'bail|required_without:email|unique:App\Models\Profile,phone',
            'email' => 'bail|required_without:phone|unique:App\Models\Profile,email',
            'password' => 'required',
        ]);

        $profile = new Profile();
        $profile->name = $request->get('name');
        $profile->phone = $request->get('phone');
        $profile->email = $request->get('email');
        $profile->password = Hash::make($request->get('password'));
        $profile->save();

        return response()->json([
            "has_error" => false,
            "message" => "User is created successfully!"
        ]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login(Request $request)
    {

        if(! $request->has('password'))
            return response()->json([
                'has_error' => true,
                'message' => "Error: you must enter your password key!"
            ]);

        if($request->has('email'))
            $credentials = $request->only(['email', 'password']);
        else if($request->has('phone'))
            $credentials = $request->only(['phone', 'password']);
        else
            return response()->json([
               'has_error' => true,
               'message' => "Error: you must enter your email or phone number keys!"
            ]);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                'has_error' => true,
                'message' => 'Error: the credentials are not correct!'
            ], 401);
        }

        // TODO:: Check if the user is verified!

        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


}
