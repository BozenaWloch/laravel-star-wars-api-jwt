<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use App\Exceptions\UnauthorizedException;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthorize
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @throws \App\Exceptions\UnauthorizedException
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $code = JsonResponse::HTTP_UNAUTHORIZED;
        $message = null;
        $user = null;

        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            $message = 'Token expired.';
        } catch (TokenInvalidException $e) {
            $message = 'Token invalid.';
        } catch (JWTException $e) {
            if (null === $message) {
                try {
                    /** @var \App\Models\User|null * */
                    $user = JWTAuth::setToken(JWTAuth::parseToken($request->header('authorization')))->authenticate();
                } catch (JWTException $exc) {
                    $message = $exc->getMessage();
                }
            } else {
                $message = 'Token absent.';
            }
        }

        if (!isset($user) && null === $message) {
            $message = 'Active user not found.';
            $code = JsonResponse::HTTP_NOT_FOUND;
        }

        if (null !== $message) {
            throw new UnauthorizedException($message, $code);
        }

        auth()->setUser($user);

        return $next($request);
    }
}
