<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 2018/8/1
 * Time: 11:53
 */

namespace Crius\Smy\Helpers;


use Exception;
use Illuminate\Http\Request;

class BusinessHelper extends SmyHelper
{
    /**
     * 获取支持的分期数
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInstallments(Request $request)
    {
        try {
//            $response = $this->manage->installments($this->addHeaderPostField($request));
            $response = ['instalments'=>[3, 6, 12], 'minLoanAmount'=>'5000', 'maxPilotCalcuAmount'=>'8000'];
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '获取成功');
    }

    /**
     * 获取借款验证码
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDynamicCodes(Request $request)
    {
//        $params = ['codeType'=>'04'];
        try {
//            $response = $this->manage->loanDynamicCodes($this->addHeaderPostField($request));
            $response = null;
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '获取成功');
    }

    /**
     * 获取还款验证码
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRepaymentDynamicCodes(Request $request)
    {
        $params = $request->only('bankCarID', 'amount');
        try {
//            $response = $this->manage->repaymentDynamicCodes($this->addHeaderPostField($request, $params));
            $response = null;
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '获取成功');
    }
}