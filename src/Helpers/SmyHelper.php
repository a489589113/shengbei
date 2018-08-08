<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/8/1
 * Time: 10:29
 */

namespace Crius\Smy\Helpers;


use Crius\Smy\Manager\SmyManager;
use Crius\Smy\Models\UserOpenId;
use Illuminate\Http\Request;

use Exception;
use StructuredResponse\StructuredResponse;

class SmyHelper
{
    use StructuredResponse;
    protected $manage;

    public function __construct(SmyManager $manage)
    {
        $this->manage = $manage;
    }

    protected function addHeaderPostField(Request $request, array $postField = [])
    {
        $postField['environment'] = $this->getEnvironment($request);
        $postField['terminal'] = $this->getTerminal($request);
        $postField['user'] = $this->getUser($request);
        if ($postField['user']) {
            $postField['externalCustNo'] = $this->getExternalCustNo($postField['user']);
        }
        $postField['authTimestamp'] = $this->getAuthTimestamp($request);
        return $postField;
    }

    protected function getExternalCustNo($mobilePhoneNo)
    {
        $record = UserOpenId::where('mobilePhoneNo', $mobilePhoneNo)->first();
        if ($record) {
            return $record->id;
        }
        return null;
    }

    protected function getEnvironment(Request $request)
    {
        try {
            //@todo dummy环境信息
            return ['deviceUniqueId' => 'E4E6D232-41E0-4335-A879-F583F1320AC6'];
//            return base64_decode(json_decode($request->header('Environment')));
        } catch (Exception $exception) {
            throw new Exception('环境信息格式错误');
        }
    }

    protected function getTerminal(Request $request)
    {
        try {
            //@todo dummy终端信息
            return ['terminalType' => 'app', 'appVersion' => '3.1.0'];
//            return base64_decode(json_decode($request->header('Terminal')));
        } catch (Exception $exception) {
            throw new Exception('环境信息格式错误');
        }
    }

    protected function getUser(Request $request)
    {
        $record = UserOpenId::where('openId', self::getOpenId($request))->first();
        return $record->mobilePhoneNo ?? null;
    }

    protected function getAuthTimestamp(Request $request)
    {
        return $request->header('AuthTimestamp');
    }

    public function parseResponse($response, $msg)
    {
        return $this->returnResp(true, $msg, $response);
    }

    protected function returnResp($status, $msg, $data = [])
    {
        if (!$status) {
            return $this->genResponse(0, $msg);
        }
        return $this->genResponse(1, $msg, $data);
    }

    protected function clearResponse()
    {
        $this->response = ['retcode' => 0, 'info' => [], 'data' => []];
    }

    public static function getOpenId(Request $request)
    {
        return 'mcfWhcyHyx2lY55rh6myIo5_hov2xwpu21fWxGiLEFA';
//        return $request->header('OpenId');
    }
}