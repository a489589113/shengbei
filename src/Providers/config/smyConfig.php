<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/8/2
 * Time: 11:47
 */

return [
    //API LINK
    'apiLink' => 'https://appsittest.smyfinancial.com/b2b-front',
    //渠道码
    'channel' => 'E23',
    //密钥
    'hmac' => 'cf2bb1c832894de2984d613ec720c7e3',

    //设备类型
    'terminalType' => 'app',
    //合作方的app渠道来源
    'appChannel' => 'meizuPay',
    //subAppChannel
    'subAppChannel' => 'meizuPayApi',
    //以后各种活动、可能有变动，暂时 default
    'activity' => 'default',
    //App语言
    'appLang' => 'cn',

    //产品类型
    'productType' => 'loan',
    //产品名称
    'productName' => 'bbd_android',
    //app类型
    'appType' => 'android',

    'meizuMiddleware' => true,

    'meizuMiddlewareClass' => "Crius\\Meizu\\Middleware\\MeizuMiddleware",
    //app名称
//   'appName' =>'android',
];