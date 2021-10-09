<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use Closure;
use Exception;
use Illuminate\Contracts\Auth\Factory as Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $request->id = $user->id;
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException){
                return response()->json([
                    'has_error' => true,
                    'message' => 'Token is Invalid'
                ]);
            }else if ($e instanceof TokenExpiredException){
                return response()->json([
                    'has_error' => true,
                    'message' => 'Token is Expired'
                ]);
            }else{
                return response()->json([
                    'has_error' => true,
                    'message' => 'Authorization Token not found'
                ]);
            }
        }
        return $next($request);
    }
}
