<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/7/31
 * Time: 14:26
 */

namespace Crius\Smy\Util;


use Crius\Smy\Config\Config;
use Exception;
use Illuminate\Support\Facades\Log;

class SDKUtil
{
    /**
     * 发送get请求
     *
     * @param $url
     * @param null $postFields
     * @return mixed
     */
    public function get($url, $postFields = null)
    {
        return $this->curl($url, 'get', $postFields);
    }

    /**
     * 发送post请求
     *
     * @param $url
     * @param null $postFields
     * @return mixed
     */
    public function post($url, $postFields = null)
    {
        return $this->curl($url, 'post', $postFields);
    }

    /**
     * 发送put请求
     *
     * @param $url
     * @param null $postFields
     * @return mixed
     */
    public function put($url, $postFields = null)
    {
        return $this->curl($url, 'PUT', $postFields);
    }

    /**
     * 发送delete请求
     *
     * @param $url
     * @param null $postFields
     * @return mixed
     */
    public function delete($url, $postFields = null)
    {
        return $this->curl($url, 'DELETE', $postFields);
    }

    private function getHeaderStr($url, &$postFields, $type)
    {
        if (!isset($postFields['terminal']) || !$postFields['terminal']) {
            throw new Exception('终端信息不能为空');
        }
        if (!isset($postFields['environment']) || !$postFields['environment']) {
            throw new Exception('环境信息不能为空');
        }
        if (!isset($postFields['authTimestamp']) || !$postFields['authTimestamp']) {
            throw new Exception('客户端时间不能为空');
        }
        if (!isset($postFields['user']) || !$postFields['user'] || !isset($postFields['externalCustNo']) || !$postFields['externalCustNo']) {
            $postFields['user'] = '';
            $postFields['externalCustNo'] = '';
        }
        $header = new Header();
        $header->setTerminal($postFields['terminal']);
        $header->setEnvironment($postFields['environment']);
        $header->setAuthTimestamp($postFields['authTimestamp']);
        $header->setRequestID();
        $header->setUser($postFields['user'], $postFields['externalCustNo']);
        unset($postFields['terminal'],$postFields['environment'],$postFields['authTimestamp'],$postFields['user'],$postFields['externalCustNo']);
        $queryField = [];
        $body = "";
        if ($type == 'get') {
            $queryField = $postFields;
        } else {
            if ($postFields) {
                $body = json_encode($postFields);
            }
        }
        $header->setAuthorization(self::byteToSign($url, $queryField, $header->getXSmy(), $body));
        return $header->genHeader();
    }

    private function curl($url, $type, $postFields = null)
    {
        Log::info($type);
        $apiLink = Config::getConfig()->apiLink . $url;
        $ch = curl_init();
        $ssl = substr($url, 0, 8) == "https://" ? TRUE : FALSE;
        $header = $this->getHeaderStr($url, $postFields, $type);
        Log::info($header);
        Log::info("body入参:");
        Log::info($postFields);
        if ($type == 'post') {
            Log::info(json_encode($postFields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postFields));
            curl_setopt($ch, CURLOPT_POST, 1);
        } elseif ($type == 'get') {
            if ($postFields) {
                $apiLink .= '?' . http_build_query($postFields);
            }
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postFields));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
        }
        Log::info("header入参:");
        Log::info($header);
        Log::info("请求URL:".$apiLink);
        curl_setopt($ch, CURLOPT_URL, $apiLink);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        if ($ssl) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }
        $response = json_decode(curl_exec($ch), true);
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch), 0);
        } else {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (200 > $httpStatusCode || $httpStatusCode >= 300) {
                throw new Exception($response['message'] ?? $httpStatusCode, $httpStatusCode);
            }
        }
        curl_close($ch);
        return $response;
    }

    public static function generateHMAC($byteToSign)
    {
//        Log::info('HeaderString:'.$byteToSign);
        $hash = base64_encode(hash_hmac('sha1', $byteToSign, Config::getConfig()->hmac, true));
//        Log::info("hmac:".$hash);
        return $hash;
    }

    public static function getBytes($string) {
        $bytes = array();
        for($i = 0; $i < strlen($string); $i++){
            $bytes[] = ord($string[$i]);
        }
        return $bytes;
    }

    public function byteToSign($url, array $queryField, array $smyHeaderData, $body)
    {
        $byteToSign = "";
        if (!$smyHeaderData) {
            throw new Exception("Header 参数缺失");
        }
        $byteToSign .= $url;
//        Log::info('加密前URi:' . $url);
        if ($queryField) {
            ksort($queryField);
            foreach ($queryField as $key => $value) {
                $queryField[$key] = urlencode($value);
            }
            $queryField = http_build_query($queryField);
            $byteToSign .= '?' . $queryField;
        }
//        Log::info('加密前参数列表:');
//        Log::info($queryField);
        ksort($smyHeaderData);
        $headerStr = '';
        foreach ($smyHeaderData as $key => $item) {
            $item = preg_replace('# #', '', $item);
            $headerStr .= "\n" . $key . ':' . $item;
        }
        $byteToSign .= $headerStr;
        $byteToSign .= "\n";
        $byteToSign .= $body;
//        Log::info('加密前header部分:');
//        Log::info($headerStr);
//        Log::info('加密前body部分:');
//        Log::info($body);
//        Log::info('组成headerString :' . $byteToSign);

        return $byteToSign;
    }

    static function genRequestID()
    {
//        return self::msectime() . self::genRandomString(19);
        return self::msectime();
    }

    static function msectime()
    {
        list($msec, $sec) = explode(' ', microtime());
        return sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    }

    public static function genRandomString($len)
    {
        $chars = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
            "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
            "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
            "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
            "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
            "3", "4", "5", "6", "7", "8", "9"
        );
        $charsLen = count($chars) - 1;
        shuffle($chars); // 将数组打乱
        $output = "";
        for ($i = 0; $i < $len; $i++) {
            $output .= $chars [mt_rand(0, $charsLen)];
        }
        return $output;
    }

    public static function genRandomNumber($len)
    {
        $number = "";
        for ($i = 0; $i < $len; $i++) {
            $number .= mt_rand(0, 9);
        }
        return $number;
    }
}