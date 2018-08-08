<?php

namespace Crius\Smy\Middleware;

use Closure;
use Crius\Smy\Models\UserOpenId;
use StructuredResponse\StructuredResponse;

class SmyMiddleware
{
    use StructuredResponse;

    protected $except = [
        'api/smy/register',
        'api/smy/users/existing',
        'api/smy/users/regDynamicCode',
        'api/smy/users/registerByDynamicCode',
        'api/smy/userInfo',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $openId = $request->header('OpenId');

        if (!$openId){
            $this->setResponseRetcode(2011);
            $this->addResponseInfo('OPENID 不能为空');
            die($this->getResponse(TRUE));
        }

        if ($this->inExceptArray($request,$this->except)) {
            return $next($request);
        }
        $record = UserOpenId::where('openId', $openId)->first();
        $phone = $record->mobilePhoneNo ?? null;
        if (!$phone){
            $this->setResponseRetcode(2012);
            $this->addResponseInfo('用户尚未注册');
            die($this->getResponse(TRUE));
        }
        return $next($request);
    }

    protected function inExceptArray($request, $excepts)
    {
        foreach ($excepts as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }
            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }
}
