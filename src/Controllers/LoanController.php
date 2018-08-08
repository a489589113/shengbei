<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/8/1
 * Time: 16:55
 */

namespace Crius\Smy\Controllers;


use Crius\Smy\Helpers\LoanHelper;
use Illuminate\Http\Request;

class LoanController extends SmyController
{
    private $helper;

    public function __construct(LoanHelper $helper)
    {
        parent::__construct();
        $this->helper = $helper;
    }

    /**
     * 申请借款
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse]
     */
    public function apply(Request $request)
    {
        $this->validateApi($request, [
            'loanAmount' => 'required',
            'instalment' => 'required',
            'bankCardID' => 'required',
            'dynamicCode' => 'required'
        ], [], [
            'loanAmount' => '借款额度',
            'instalment' => '分期数',
            'bankCardID' => '银行卡ID',
            'dynamicCode' => '验证码'
        ]);
        return $this->helper->apply($request);
    }

    /**
     * 借款费率试算
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ratesCalculate(Request $request)
    {
        $this->validateApi($request, [
            'loanAmount' => 'required',
            'instalment' => 'required'
        ], [], [
            'loanAmount' => '借款额度',
            'instalment' => '分期数',
        ]);
        return $this->helper->ratesCalculate($request);
    }

    /**
     * 查询借款记录(只能查询接口成功记录)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function successHistory(Request $request)
    {
        $this->validateApi($request, [
            'pageNo' => 'nullable|integer|min:1',
        ], [], [
            'pageNo' => '页码',
        ]);
        return $this->helper->successHistory($request);
    }

    /**
     * 查询借款结果（包含失败记录）
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getResults(Request $request)
    {
        $this->validateApi($request, [
            'transSeqNo' => 'required|string',
        ], [], [
            'transSeqNo' => '交易流水号',
        ]);
        return $this->helper->getResults($request);
    }
}