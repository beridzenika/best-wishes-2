<?php

namespace Winter\User\Classes;

use Illuminate\Http\Request;
use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class HeadersMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->headers->has('authorization')) {
            config(['local.AUTH_TOKEN' => $request->header('authorization')]);
        }

        $headers = [
            'Access-Control-Allow-Origin'      => $request->server('HTTP_ORIGIN'),
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => $request->header('Access-Control-Request-Headers')
        ];
        if ($request->isMethod('OPTIONS'))
        {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        $response = $next($request);

        foreach($headers as $key => $value)
        {
            $response->header($key, $value);
        }
        return $response;
    }
}
