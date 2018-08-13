<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/7/31
 * Time: 14:45
 */

namespace Crius\Smy\Config;


class Config
{
    private static $_config = null;

    public static function getConfig()
    {
        if (Config::$_config == null) {
            Config::$_config = new Config();
        }
        return Config::$_config;
    }

    //API LINK
    private $apiLink;
    //渠道码
    private $channel;
    //密钥
    private $hmac;

    //设备类型
    private $terminalType;
    //合作方的app渠道来源
    private $appChannel;
    //subAppChannel
    private $subAppChannel;
    //以后各种活动、可能有变动，暂时 default
    private $activity;
    //App语言
    private $appLang;

    //产品类型
    private $productType;
    //产品名称
    private $productName;
    //app类型
    private $appType;
    //魅族中间键
    private $meizuMiddleware;
    private $meizuMiddlewareClass;

    public function __construct()
    {
        $config = config('smyConfig');
        $this->apiLink = $config["apiLink"] ?? null;
        $this->channel = $config["channel"] ?? null;
        $this->hmac = $config["hmac"] ?? null;
        $this->terminalType = $config["terminalType"] ?? null;
        $this->appChannel = $config["appChannel"] ?? null;
        $this->subAppChannel = $config["subAppChannel"] ?? null;
        $this->activity = $config["activity"] ?? null;
        $this->appLang = $config["appLang"] ?? null;
        $this->productType = $config["productType"] ?? null;
        $this->productName = $config["productName"] ?? null;
        $this->appType = $config["appType"] ?? null;
        $this->meizuMiddleware = $config["meizuMiddleware"] ?? null;
        $this->meizuMiddlewareClass = $config["meizuMiddlewareClass"] ?? null;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($property_name)
    {
        if (isset($this->$property_name)) {
            return ($this->$property_name);
        } else {
            return (NULL);
        }
    }
}