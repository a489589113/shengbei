<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 3/25/17
 * Time: 15:08
 */

namespace Crius\Smy\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnableCrossRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Log::info($request->headers);
        $headers = [
            'Access-Control-Allow-Origin' => (config('app.crossrequest_allow') ? '*' : null),
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept, X-Auth-Token',
            'Access-Control-Allow-Credentials' => 'true'
        ];
//        $response->header('Access-Control-Allow-Origin', '*');
//        $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, Accept');
//        $response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS');
//        $response->header('Access-Control-Allow-Credentials', 'false');
//        if($request->getMethod() == "OPTIONS") {
//            $response = Response::create('OK', 200, $headers);
//            return $response;
//        }

        $response = $next($request);
        foreach ($headers as $key => $value)
            $response->header($key, $value);
        return $response;
    }

}