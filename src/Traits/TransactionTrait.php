<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/8/3
 * Time: 16:20
 */

namespace Crius\Smy\Traits;


trait TransactionTrait
{
    /**
     * 获取支持的分期数
     *
     * @param $postData
     * @return mixed
     */
    public function installments($postFields)
    {
        return $this->util->get('/bdapi/installments', $postFields);
    }

    /**
     * 借款费率试算
     *
     * @param $postData
     * @return mixed
     */
    public function ratesCalculate($postFields)
    {
        return $this->util->get('/bdapi/loans/rates_calculate', $postFields);
    }

    /**
     * 获取借款短信验证码
     *
     * @param $postData
     * @return mixed
     */
    public function loanDynamicCodes($postFields)
    {
        $postFields['codeType'] = '04';
        return $this->util->post('/bdapi/dynamic-codes', $postFields);
    }

    /**
     * 申请借款
     *
     * @param $postData
     * @return mixed
     */
    public function applyLoan($postFields)
    {
        return $this->util->post('/bdapi/loans', $postFields);
    }

    /**
     * 查询借款记录(只能查询接口成功记录)
     *
     * @param $postData
     * @return mixed
     */
    public function loanRecords($postFields)
    {
        return $this->util->get('/bdapi/loans', $postFields);
    }

    /**
     * 查询借款结果（包含失败记录）
     *
     * @param $postData
     * @return mixed
     */
    public function loansLoaned($postFields)
    {
        return $this->util->get('/bdapi/loans/loaned', $postFields);
    }

    /**
     * 查询应还款计划
     *
     * @param $postData
     * @return mixed
     */
    public function repaymentsPlans($postFields)
    {
        return $this->util->get('/bdapi/repayments/plans', $postFields);
    }

    /**
     * 获取还款短信验证码
     *
     * @param $postData
     * @return mixed
     */
    public function repaymentDynamicCodes($postFields)
    {
        return $this->util->post('/bdapi/repayments/dynamic-codes', $postFields);
    }

    /**
     * 还款
     *
     * @param $postData
     * @return mixed
     */
    public function repayments($postFields)
    {
        return $this->util->post('/bdapi/repayments', $postFields);
    }

    /**
     * 查询还款记录
     *
     * @param $postData
     * @return mixed
     */
    public function repaymentRecords($postFields)
    {
        return $this->util->get('/bdapi/repayments', $postFields);
    }

    /**
     * 查询还款结果
     *
     * @param $postData
     * @return mixed
     */
    public function repaymentResults($postFields)
    {
        return $this->util->get('/bdapi/repayments/repaid', $postFields);
    }

    /**
     * 还款（不需获取短信验证码）
     *
     * @param $postData
     * @return mixed
     */
    public function repaymentWithoutDynamicCodes($postFields)
    {
        return $this->util->post('/bdapi/repayments/without-dynamic-codes', $postFields);
    }
}