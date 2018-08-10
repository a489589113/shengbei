<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/8/1
 * Time: 10:29
 */

namespace Crius\Smy\Helpers;


use Crius\Smy\Jobs\SendAppListToShengBei;
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
        return 1;
    }

    protected function getEnvironment(Request $request)
    {
        try {
            //@todo dummy环境信息
//            return ['deviceUniqueId' => 'E4E6D232-41E0-4335-A879-F583F1320AC6'];
//            return ['deviceUniqueId' => '0'];
            return json_decode(base64_decode($request->header('Environment')),true);
        } catch (Exception $exception) {
            throw new Exception('环境信息格式错误');
        }
    }

    protected function getTerminal(Request $request)
    {
        try {
            //@todo dummy终端信息
//            return ['terminalType' => 'app', 'appVersion' => '3.1.0'];
            return json_decode(base64_decode($request->header('Terminal')),true);
        } catch (Exception $exception) {
            throw new Exception('环境信息格式错误');
        }
    }

    protected function getUser(Request $request)
    {
        $record = UserOpenId::where('openId', self::getOpenId($request))->first();
        return $record->mobilePhoneNo ?? 1;
    }

    protected function getAuthTimestamp(Request $request)
    {
        //@todo dummy终端信息
        return $request->header('AuthTimestamp');
//        return SDKUtil::msectime();
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
//        return 'mcfWhcyHyx2lY55rh6myIo5_hov2xwpu21fWxGiLEFA';
        return $request->header('Openid');
    }

    protected function base64EncodeImage($filePath)
    {
        return base64_encode(file_get_contents($filePath));
    }

    /**
     * 发送app列表数据
     *
     * @param Request $request
     */
    protected function sendAppList(Request $request)
    {
        try {
            $appInfoList = $request->get('appInfoList');
            if ($appInfoList) {
                $postField['appInfoList'] = json_decode($appInfoList, true);
                if ($postField['appInfoList']) {
                    SendAppListToShengBei::dispatch($this->addHeaderPostField($request, $postField),$this->manage);
                }
            }
        } catch (Exception $exception) {
        }
    }
}