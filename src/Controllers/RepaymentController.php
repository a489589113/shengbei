<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/8/1
 * Time: 17:38
 */

namespace Crius\Smy\Controllers;


use Crius\Smy\Helpers\RepaymentHelper;
use Illuminate\Http\Request;

class RepaymentController extends SmyController
{
    private $helper;

    public function __construct(RepaymentHelper $helper)
    {
        parent::__construct();
        $this->helper = $helper;
    }

    /**
     * 查询应还款计划
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse]
     */
    public function getPlans(Request $request)
    {
        return $this->helper->plans($request);
    }

    /**
     * 查询还款记录
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function history(Request $request)
    {
        $this->validateApi($request, [
            'pageNo' => 'nullable|integer|min:1',
        ], [], [
            'pageNo' => '页码',
        ]);
        return $this->helper->history($request);
    }

    /**
     * 查询还款结果
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

    /**
     * 未还清借款页
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unRepaymentLoans(Request $request)
    {
        return $this->helper->unRepaymentLoans($request);
    }

    /**
     * 还款
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function repayment(Request $request)
    {
        $this->validateApi($request, [
            'dynamicCode' => 'required|string',
            'bankCardID' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'repaymentPlans' => 'required|json',
        ], [], [
            'dynamicCode' => '动态验证码',
            'bankCardID' => '银行卡ID',
            'amount' => '还款金额',
            'repaymentPlans' => '还款计划',
        ]);
        return $this->helper->repayment($request);
    }
}