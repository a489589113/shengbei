<?php

namespace Crius\Smy\Controllers;

use Illuminate\Http\Request;
use StructuredResponse\StructuredResponse;
use Crius\Smy\Helpers\IdentityHelper;
use Crius\Smy\Rules\Mobile;


class IdentityController extends SmyController
{
    use StructuredResponse;

    private $helper;

    public function __construct(IdentityHelper $helper)
    {
        parent::__construct();
        $this->helper = $helper;
    }

    /**
     * 判断是否已注册
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkExistence(Request $request)
    {
        $this->validateApi($request, [
            'mobilePhoneNo' => new Mobile(),
            'idNo' => 'required_without:mobilePhoneNo'
        ], [], [
            'mobilePhoneNo' => '手机号码',
            'idNo' => '身份证号'
        ]);
        return $this->helper->checkExistence($request);
    }

    /**
     * 添加储蓄卡
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addDebitCard(Request $request)
    {
        $this->validateApi($request, [
            'bankCardNo' => 'required',
            'mobilePhoneNo' => ['required', new Mobile()],
            'autoRepayment' => 'required|Boolean',
            'dynamicCode' => 'required',
        ], [], [
            'bankCardNo' => '银行卡号',
            'mobilePhoneNo' => '银行预留手机号',
            'autoRepayment' => '是否设置自动还款',
            'dynamicCode' => '验证码',
        ]);
        return $this->helper->addDebitCard($request);
    }

    /**
     * 添加信用卡
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCreditCard(Request $request)
    {
        $this->validateApi($request, [
            'bankCardNo' => 'required',
            'mobilePhoneNo' => new Mobile()
        ], [], [
            'bankCardNo' => '信用卡号',
            'mobilePhoneNo' => '银行预留手机号'
        ]);
        return $this->helper->addCreditCard($request);
    }

    /**
     * 删除银行卡
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCard(Request $request)
    {
        $this->validateApi($request, ['bankCardID' => 'required'], [], [
            'bankCardID' => '银行卡ID'
        ]);
        return $this->helper->deleteCard($request);

    }

    /**
     * 设置/取消自动还款
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setAutoRepayment(Request $request)
    {
        $this->validateApi($request, [
            'bankCardID' => 'required|String',
            'autoRepayment' => 'required|Boolean'
        ], [], [
            'bankCardID' => '银行卡ID',
            'autoRepayment' => '是否自动还款'
        ]);
        return $this->helper->setAutoRepayment($request);
    }

    /**
     * 获取绑卡协议
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProtocols(Request $request)
    {
        return $this->helper->getProtocols($request);
    }

    /**
     *获取查询银行征信提示
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBankCreditPrompt(Request $request)
    {
        return $this->helper->getBankCreditPrompt($request);
    }

    /**
     * 发送注册动码
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendRegDynamicCode(Request $request)
    {
        $this->validateApi($request, [
            'mobilePhoneNo' => ['required', new Mobile()]
        ], [], ['mobilePhoneNo' => '手机号码']);
        return $this->helper->sendRegDynamicCode($request);
    }

}
