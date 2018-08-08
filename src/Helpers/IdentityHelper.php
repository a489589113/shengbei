<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 2018/8/1
 * Time: 15:47
 */

namespace Crius\Smy\Helpers;


use Exception;
use Illuminate\Http\Request;

class IdentityHelper extends SmyHelper
{
    /**
     * 判断是否已注册
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkExistence(Request $request)
    {
//        dump($request);
        $postFields = $request->only('mobilePhoneNo','idNo');
        try {
            $response = $this->manage->userExisting($this->addHeaderPostField($request,$postFields));
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '用户存在');
    }

    /**
     * 添加储蓄卡
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addDebitCard(Request $request)
    {
        $params = $request->only('bankCardNo', 'mobilePhoneNo', 'autoRepayment', 'dynamicCode', 'name', 'idNo');
        $params['bankCardType'] = '1';
        $params['needValid'] = true;
        try {
//            $response = $this->manage->addBankCard($this->addHeaderPostField($request, $params));
            $response = ['bankId'=>'01040000', 'bankCardID'=>$request->get('bankCardNo')];
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '添加成功');
    }

    /**
     * 添加信用卡
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCreditCard(Request $request)
    {
        $params = $request->only('bankCardNo', 'mobilePhoneNo', 'name', 'idNo');
        $params['bankCardType'] = '2';
        $params['autoRepayment'] = false;
        $params['needValid'] = false;
        try {
//            $response = $this->manage->addBankCard($this->addHeaderPostField($request, $params));
            $response = ['bankId'=>'01020000', 'bankCardID'=>$request->get('bankCardNo')];
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '添加成功');
    }

    /**
     * 删除银行卡
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCard(Request $request)
    {
        $params = $request->only('bankCardID');
        try {
//            $response = $this->manage->deleteBankCard($this->addHeaderPostField($request, $params));
            $response = null;
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '删除成功');
    }

    /**
     * 设置/取消自动还款
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setAutoRepayment(Request $request)
    {
        $params = $request->only('bankCardID', 'autoRepayment');
        try {
//            $response = $this->manage->autoRepayment($this->addHeaderPostField($request, $params));
            $response = null;
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        if ($request->get('autoRepayment')) {
            return $this->parseResponse($response, '设置自动还款成功');
        } else {
            return $this->parseResponse($response, '取消自动还款成功');
        }
    }

    /**
     * 获取绑卡协议
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProtocols(Request $request)
    {
        try {
//            $response = $this->manage->getProtocols($this->addHeaderPostField($request));
            $response = [['type'=>'01', 'title'=>'个人信息查询及使用授权书', 'url'=>'https://static.smyfinancial.com/static_app/agreement/shengbei_person_credit/shengbei_personcredit_agreement_h5.html'],
                         ['type'=>'02', 'title'=>'个人征信信息查询及使用授权书', 'url'=>'https://static.smyfinancial.com/static_app/agreement/shengbei_person_info/shengbei_personinfo_agreement_h5.html'],
                         ['type'=>'03', 'title'=>'消费贷授信协议', 'url'=>'https://static.smyfinancial.com/static_app/agreement/harbin/heb_agreement_h5.html'],
                         ['type'=>'04', 'title'=>'萨摩耶服务协议', 'url'=>'https://static.smyfinancial.com/static_app/agreement/smy_service/smy_service_agreement_h5.html'],
                         ['type'=>'05', 'title'=>'账户委托扣款授权书', 'url'=>'https://static.smyfinancial.com/static_app/agreement/shengbei_deduct/deduct_agreement_h5.html'],
                         ['type'=>'06', 'title'=>'自动还款协议', 'url'=>'https://static.smyfinancial.com/static_app/agreement/shengbei_repayment/repayment_agreement_h5.html']];
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '获取成功');
    }

    /**
     * 获取查询银行征信提示
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBankCreditPrompt(Request $request)
    {
        try {
//            $response = $this->manage->getBankCreditPrompt($this->addHeaderPostField($request));
            $response = ['prompt'=>'征信提示', 'personalCreditAuthUrl'=>''];
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '获取成功');
    }

    /**
     * 发送注册动码
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendRegDynamicCode(Request $request)
    {
        $params = $request->only('mobilePhoneNo');
        $params['dynamicCodeType'] = '01';
        try {
//            $response = $this->manage->sendRegDynamicCode($this->addHeaderPostField($request, $params));
            $response = null;
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '获取成功');
    }
}