<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/8/2
 * Time: 11:47
 */

$quoted = preg_quote('/', '/');

$baseUrl = preg_replace('/(?:' . $quoted . ')+$/u', '', env('APP_URL', 'http://localhost')) . '/';
return [
    '01000000' => [
        'bankId' => '01000000',
        'bankName' => '中国邮政',
        'bankLogo' => $baseUrl . 'vendor/smy/logo/youzheng.png',
        'bankColor' => '#3bc06b',
        'bankColorEnd' => '#3bc06b',
    ],
    '01020000' => [
        'bankId' => '01020000',
        'bankName' => '工商银行',
        'bankLogo' => $baseUrl . 'vendor/smy/logo/gongshang.png',
        'bankColor' => '#e23639',
        'bankColorEnd' => '#e84245',
    ],
    '01030000' => [
        'bankId' => '01030000',
        'bankName' => '农业银行',
        'bankLogo' => $baseUrl . 'vendor/smy/logo/nongye.png',
        'bankColor' => '#26b6aa',
        'bankColorEnd' => '#26b6aa',
    ],
    '01040000' => [
        'bankId' => '01040000',
        'bankName' => '中国银行',
        'bankLogo' => $baseUrl . 'vendor/smy/logo/zhongguo.png',
        'bankColor' => '#e23639',
        'bankColorEnd' => '#e84245',
    ],
    '01050000' => [
        'bankId' => '01050000',
        'bankName' => '建设银行',
        'bankLogo' => $baseUrl . 'vendor/smy/logo/jianshe.png',
        'bankColor' => '#198ded',
        'bankColorEnd' => '#198ded',
    ],
    '03010000' => [
        'bankId' => '03010000',
        'bankName' => '交通银行',
        'bankLogo' => $baseUrl . 'vendor/smy/logo/jiaotong.png',
        'bankColor' => '#198ded',
        'bankColorEnd' => '#198ded',
    ],
    '03020000' => [
        'bankId' => '03020000',
        'bankName' => '中信银行',
        'bankLogo' => $baseUrl . 'vendor/smy/logo/zhongxin.png',
        'bankColor' => '#e23639',
        'bankColorEnd' => '#e84245',
    ],
    '03030000' => [
        'bankId' => '03030000',
        'bankName' => '光大银行',
        'bankLogo' => $baseUrl . 'vendor/smy/logo/guangda.png',
        'bankColor' => '#ffaf00',
        'bankColorEnd' => '#ffaf00',
    ],
    '03040000' => [
        'bankId' => '03040000',
        'bankName' => '华夏银行',
        'bankLogo' => $baseUrl . 'vendor/smy/logo/huaxia.png',
        'bankColor' => '#e23639',
        'bankColorEnd' => '#e84245',
    ],
    '03050000' => [
        'bankId' => '03050000',
        'bankName' => '民生银行',
        'bankLogo' => $baseUrl . 'vendor/smy/logo/minsheng.png',
        'bankColor' => '#04c0cf',
        'bankColorEnd' => '#04c0cf',
    ],
    '03060000' => [
        'bankId' => '03060000',
        'bankName' => '广东发展银行',
        'bankLogo' => $baseUrl . 'vendor/smy/logo/guangdongfazhan.png',
        'bankColor' => '#e23639',
        'bankColorEnd' => '#e84245',
    ],
    '03070000' => [
        'bankId' => '03070000',
        'bankName' => '平安银行',
        'bankLogo' => $baseUrl . 'vendor/smy/logo/pingan.png',
        'bankColor' => '#fc5b23',
        'bankColorEnd' => '#fc5b23',
    ],
    '03080000' => [
        'bankId' => '03080000',
        'bankName' => '招商银行',
        'bankLogo' => $baseUrl . 'vendor/smy/logo/zhaoshang.png',
        'bankColor' => '#e23639',
        'bankColorEnd' => '#e84245',
    ],
    '03090000' => [
        'bankId' => '03090000',
        'bankName' => '兴业银行',
        'bankLogo' => $baseUrl . 'vendor/smy/logo/xingye.png',
        'bankColor' => '#198ded',
        'bankColorEnd' => '#198ded',
    ],
    '03100000' => [
        'bankId' => '03100000',
        'bankName' => '浦东发展银行',
        'bankLogo' => $baseUrl . 'vendor/smy/logo/pudongfazhan.png',
        'bankColor' => '#198ded',
        'bankColorEnd' => '#198ded',
    ],
    '04010000' => [
        'bankId' => '04010000',
        'bankName' => '上海银行',
        'bankLogo' => $baseUrl . 'vendor/smy/logo/shanghai.png',
        'bankColor' => '#ffaf00',
        'bankColorEnd' => '#ffaf00',
    ],
    '04130000' => [
        'bankId' => '04130000',
        'bankName' => '广州银行',
        'bankLogo' => $baseUrl . 'vendor/smy/logo/guangzhou.png',
        'bankColor' => '#e23639',
        'bankColorEnd' => '#e84245',
    ],
    '04470000' => [
        'bankId' => '04470000',
        'bankName' => '兰州银行',
        'bankLogo' => $baseUrl . 'vendor/smy/logo/lanzhou.png',
        'bankColor' => '#198ded',
        'bankColorEnd' => '#198ded',
    ],
    'default' => [
        'bankLogo' => $baseUrl . 'vendor/smy/logo/default.png',
        'bankColor' => '#cccccc',
        'bankColorEnd' => '#cccccc',
    ],
];