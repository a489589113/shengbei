<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/7/31
 * Time: 16:30
 */

namespace Crius\Smy\Manager;


use Crius\Smy\Traits\CardTrait;
use Crius\Smy\Traits\RegisterTrait;
use Crius\Smy\Traits\TransactionTrait;
use Crius\Smy\Util\SDKUtil;

class SmyManager
{
    use CardTrait,RegisterTrait,TransactionTrait;

    protected $util;

    public function __construct()
    {
        $this->util = new SDKUtil();
    }

    /**
     * app列表发送
     *
     * @param $postFields
     * @return mixed
     */
    public function sendApplist($postFields)
    {
        return $this->util->post('/bdapi/users/sendApplist', $postFields);
    }

}