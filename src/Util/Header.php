<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/7/31
 * Time: 14:47
 */

namespace Crius\Smy\Util;


use Crius\Smy\Config\Config;
use Exception;

class Header
{
    public $header = [];

    public function __construct()
    {
        $this->header['content-Type'] = "application/json";
//        $this->header['content-Type'] = "application/json;charset=utf-8";
//        $this->header['Accept'] = "application/json";
    }

    /**
     * 设置身份认证
     *
     * @param $byteToSign
     */
    public function setAuthorization($byteToSign)
    {
        $this->header['Authorization'] = 'SMY ' . Config::getConfig()->channel . ':' . SDKUtil::generateHMAC($byteToSign);
    }

    /**
     * 设置用户
     */
    public function setUser($mobilePhoneNo,$custNo)
    {
        $this->header['X-SMY-User'] = 'mobilePhoneNo='.$mobilePhoneNo.';externalCustNo='.$custNo;
    }

    /**
     * 设置请求序号，不能重复。最长32个字符(数字+字母)
     */
    public function setRequestID()
    {
        $requestId = SDKUtil::genRequestID();
//        $this->header['X-SMY-Request-ID'] = $requestId;
        $this->header['X-SMY-Request-ID'] = $requestId;
    }

    /**
     * 设置客户端当前时间
     */
    public function setAuthTimestamp($timestamp)
    {
//        $this->header['X-SMY-Auth-Timestamp'] = $timestamp;
        $this->header['X-SMY-Auth-Timestamp'] = $timestamp;
    }

    /**
     * 设置终端信息
     *
     * @param array $terminal
     * @throws Exception
     */
    public function setTerminal(array $terminal = [])
    {
        $terminal = array_merge($terminal, [
            'terminalType' => Config::getConfig()->terminalType,
            'appChannel' => Config::getConfig()->appChannel,
            'subAppChannel' => Config::getConfig()->subAppChannel,
            'activity' => Config::getConfig()->activity,
            'productType' => Config::getConfig()->productType,
            'productName' => Config::getConfig()->productName,
            'appType' => Config::getConfig()->appType,
        ]);
        $headArr = [];
        foreach ($terminal as $key => $value) {
            if (!is_string($value)) {
                throw new Exception("终端信息中所有值必须为 string");
            }
            array_push($headArr, $key . '=' . urlencode($value));
        }
//        $this->header['X-SMY-Terminal'] = urlencode(implode(';',$headArr));
        $this->header['X-SMY-Terminal'] = implode(';', $headArr);
    }

    /**
     * 设置环境信息
     *
     * @param array $environment
     * @throws Exception
     */
    public function setEnvironment(array $environment = [])
    {
        $headArr = [];
        foreach ($environment as $key => $value) {
            if (!is_string($value)) {
                throw new Exception("环境信息中所有值必须为 string");
            }
            array_push($headArr, $key . '=' . urlencode($value));
        }
//        $this->header['X-SMY-Environment'] = urlencode(implode(';',$headArr));
        $this->header['X-SMY-Environment'] = implode(';', $headArr);
    }

    /**
     * 设置tokenID，已废弃
     *
     * @param $tokenId
     */
    public function setChannelToken($tokenId)
    {
        $this->header['X-SMY-ChannelToken'] = $tokenId;
    }

    /**
     * 获取X-SMY类型headers
     *
     * @return array
     */
    public function getXSmy()
    {
        $xSmy = [];
        foreach ($this->header as $item => $value) {
            if (preg_match_all('/^X-SMY-.+$/', $item) ? true : false) {
                $xSmy[strtolower($item)] = $value;
            }
        }
        return $xSmy;
    }

    /**
     * 生成headers数组
     *
     * @return array
     */
    public function genHeader()
    {
        $header = [];
        foreach ($this->header as $item => $value) {
            array_push($header, $item . ':' . $value);
        }
        return $header;
    }
}