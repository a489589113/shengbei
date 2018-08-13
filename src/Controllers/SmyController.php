<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/8/8
 * Time: 16:24
 */

namespace Crius\Smy\Controllers;


use App\Http\Controllers\Controller;
use Crius\Smy\Config\Config;
use Crius\Smy\Exceptions\ValidateException;
use Crius\Smy\Middleware\EnableCrossRequestMiddleware;
use Crius\Smy\Middleware\SmyMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SmyController extends Controller
{
    public function __construct()
    {
        $middleware = [EnableCrossRequestMiddleware::class, SmyMiddleware::class];
        if (Config::getConfig()->meizuMiddleware && class_exists(Config::getConfig()->meizuMiddlewareClass)) {
            array_push($middleware, Config::getConfig()->meizuMiddlewareClass);
        }
        Log::info($middleware);
        $this->middleware($middleware);
    }

    public function validateApi(Request $request, array $rules,
                                array $messages = [], array $customAttributes = [])
    {
        $validate = $this->getValidationFactory()
            ->make($request->all(), $rules, $messages, $customAttributes);

        if ($validate->fails()) {
            $this->throwError($validate->errors()->first());
        }
    }

    protected function throwError($error)
    {
        $exception = new ValidateException();
        $exception->render($error);
        throw $exception;
    }
}