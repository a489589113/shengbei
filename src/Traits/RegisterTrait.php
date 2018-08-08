<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/8/3
 * Time: 15:49
 */

namespace Crius\Smy\Traits;


trait RegisterTrait
{

    /**
     * 判断客户是否已注册
     *
     * @param $postData
     * @return mixed
     */
    public function userExisting($postFields)
    {
        return $this->util->get('/bdapi/users/existing', $postFields);
    }

    /**
     * 提交注册
     *
     * @param $postData
     * @return mixed
     */
    public function userRegister($postFields)
    {
        return $this->util->put('/bdapi/users', $postFields);
    }

    /**
     * 发送注册动码
     *
     * @param $postFields
     * @return mixed
     */
    public function sendRegDynamicCode($postFields)
    {
        return $this->util->post('/bdapi/users/sendDynamicCode', $postFields);
    }

    /**
     * 验证码注册
     *
     * @param $postFields
     * @return mixed
     */
    public function registerByDynamicCode($postFields)
    {
        return $this->util->post('/bdapi/users/registerByDynamicCode', $postFields);
    }

    /**
     * 查询客户信息
     *
     * @param $postFields
     * @return mixed
     */
    public function userInfo($postFields)
    {
        return $this->util->get('/bdapi/users/credits', $postFields);
    }

    /**
     * 提交联系人信息
     *
     * @param $postFields
     * @return mixed
     */
    public function subContactInfo($postFields)
    {
        return $this->util->post('/bdapi/users/apply-infos/contacts', $postFields);
    }

    /**
     * 提交身份证信息
     *
     * @param $postFields
     * @return mixed
     */
    public function subIdInfo($postFields)
    {
        return $this->util->post('/bdapi/users/id-infos', $postFields);
    }

    /**
     * 提交活体信息
     *
     * @param $postFields
     * @return mixed
     */
    public function subLivingInfo($postFields)
    {
        return $this->util->post('/bdapi/users/living-infos', $postFields);
    }

    /**
     * 手机号码认证
     *
     * @param $postFields
     * @return mixed
     */
    public function subPhoneAuth($postFields)
    {
        return $this->util->post('/bdapi/mobile-phones/authenticate', $postFields);
    }

}