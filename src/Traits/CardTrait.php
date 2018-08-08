<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/8/3
 * Time: 15:49
 */

namespace Crius\Smy\Traits;


trait CardTrait
{
    /**
     * 添加银行卡
     *
     * @param $postFields
     * @return mixed
     */
    public function addBankCard($postFields)
    {
        return $this->util->post('/bdapi/bank-cards', $postFields);
    }

    /**
     * 删除银行卡
     *
     * @param $postFields
     * @return mixed
     */
    public function deleteBankCard($postFields)
    {
        if (!isset($postFields['bankCardID']) || !$postFields['bankCardID']) {
            throw new \Exception('银行卡ID不能为空');
        }
        return $this->util->delete('/bdapi/bank-cards/' . $postFields['bankCardID']);
    }

    /**
     * 获得银行卡预留手机动态码
     *
     * @param $postFields
     * @return mixed
     */
    public function getDynamicCodes($postFields)
    {
        return $this->util->post('/bdapi/bank-cards/dynamic-codes', $postFields);
    }

    /**
     * 查询绑定银行卡
     *
     * @param $postFields
     * @return mixed
     */
    public function getBankCards($postFields)
    {
        return $this->util->get('/bdapi/bank-cards', $postFields);
    }

    /**
     * 设置/取消自动还款
     *
     * @param $postFields
     * @return mixed
     */
    public function autoRepayment($postFields)
    {
        return $this->util->post('/bdapi/repayments/settings', $postFields);
    }

    /**
     * 获取绑卡协议
     *
     * @param $postFields
     * @return mixed
     */
    public function getProtocols($postFields)
    {
        return $this->util->get('/bdapi/bank-cards/protocols', $postFields);
    }

    /**
     * 获取查询银行征信提示
     *
     * @param $postFields
     * @return mixed
     */
    public function getBankCreditPrompt($postFields)
    {
        return $this->util->get('/bdapi/bank-cards/bank-credit-prompt', $postFields);
    }
}