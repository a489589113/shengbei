<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/8/1
 * Time: 15:42
 */

namespace Crius\Smy\Helpers;


use Crius\Smy\Util\SDKUtil;
use Exception;
use Illuminate\Http\Request;

class LoanHelper extends SmyHelper
{

    /**
     * 申请借款
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apply(Request $request)
    {
        $postField = $request->only('loanAmount', 'instalment', 'bankCardID', 'dynamicCode');
        try {
//            $response = $this->manage->test($this->addHeaderPostField($request,$postField));
            $response = [
                'transSeqNo' => time() . SDKUtil::genRandomNumber(4),
                'bank' => '交通银行',
                'overduePrompt' => '逾期提示'
            ];
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '申请提交成功');
    }

    /**
     * 借款费率试算
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ratesCalculate(Request $request)
    {
        $postField = $request->only('loanAmount', 'instalment');
        try {
//            $response = $this->manage->test($this->addHeaderPostField($request,$postField));
            /** @var integer $capitalAmount 每期本金 */
            $capitalAmount = '1000.00';
            /** @var integer $feeAmount 每期费用 */
            $feeAmount = '10.00';
            /** @var integer $totalFeeAmount 总费用 */
            $totalFeeAmount = '30.00';
            /** @var integer $totalServiceChargeFeeAmount 总服务费 */
            $totalServiceChargeFeeAmount = '20.00';
            /** @var integer $totalCouponFeeAmount 总优惠手续费 */
            $totalCouponFeeAmount = '10.00';
            /** @var integer $totalFreeFeeCount 总优惠期数 */
            $totalFreeFeeCount = '3';
            /** @var integer $creditCouponAmount 比信用卡优惠金额 */
            $creditCouponAmount = '10.00';
            /** @var double $creditCouponPercent 比信用卡优惠百分百比 */
            $creditCouponPercent = '0.05';
            /** @var string $custLevelDesc 等级描述 */
            $custLevelDesc = '享信用卡日利率0.5‰的';
            /** @var string $custLevelDiscount 等级折扣 */
            $custLevelDiscount = '9.8折';
            /** @var double $monthlyInterest 月利率 */
            $monthlyInterest = '0.05';
            $response = [
                'capitalAmount' => $capitalAmount,
                'feeAmount' => $feeAmount,
                'totalFeeAmount' => $totalFeeAmount,
                'totalServiceChargeFeeAmount' => $totalServiceChargeFeeAmount,
                'totalCouponFeeAmount' => $totalCouponFeeAmount,
                'totalFreeFeeCount' => $totalFreeFeeCount,
                'creditCouponAmount' => $creditCouponAmount,
                'creditCouponPercent' => $creditCouponPercent,
                'custLevelDesc' => $custLevelDesc,
                'custLevelDiscount' => $custLevelDiscount,
                'monthlyInterest' => $monthlyInterest,
            ];
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '获取成功');
    }

    /**
     * 查询借款记录(只能查询接口成功记录)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function successHistory(Request $request)
    {
        $postField['pageNo'] = $request->get('pageNo', 1);
        try {
//            $response = $this->manage->test($this->addHeaderPostField($request,$postField));
            $response = [
                'pageNo' => $postField['pageNo'], //当前页
                'pageSize' => 10, //页大小
                'pageCount' => 100, //总共多少页
                'data' => [
                    [
                        'transAmt' => '1000',//借款金额
                        'transSeqno' => '1123211254566',//交易流水号
                        'instalmentTotalCount' => '3',//分期总数
                        'bankCardNo' => '2116',//借款银行卡号（后4位）
                        'bankCardType' => '1',//银行卡类型("1":储蓄卡,"2":信用卡)
                        'bankName' => '招商银行',//借款银行
                        'loanType' => '2',//借款类型(2 - 余额代偿)
                        'loanStatus' => array_rand(['00', '01', '02', '03'], 1),//借款状态 00-未处理 01-打款中 02-已打款 03-打款失败
                        'repayAmtByPeriod' => '310',//每期还款总额
                        'repayCapitalByPeriod' => '300',//每期还款本金
                        'repayFeeByPeriod' => '10',//每期还款手续费
                        'transTime' => time(),//申请时间
                        'payTime' => time(),//打款时间
                        'moneylendBankName' => '招商银行',//放款银行
                    ]
                ] //记录数据
            ];
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '查询成功');
    }

    /**
     * 查询借款结果（包含失败记录）
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getResults(Request $request)
    {
        $postField['transSeqNo'] = $request->get('transSeqNo');
        try {
//            $response = $this->manage->test($this->addHeaderPostField($request,$postField));
            $transSeqNo = explode(',', $postField['transSeqNo']);
            $response = [
                [
                    'transAmt' => '1000',//借款金额
                    'transSeqno' => $transSeqNo[0],//交易流水号
                    'instalmentTotalCount' => '3',//分期总数
                    'bankCardNo' => '2116',//借款银行卡号（后4位）
                    'bankCardType' => '1',//银行卡类型("1":储蓄卡,"2":信用卡)
                    'bankName' => '招商银行',//借款银行
                    'loanType' => '2',//借款类型(2 - 余额代偿)
                    'loanStatus' => array_rand(['00', '01', '02', '03'], 1),//借款状态 00-未处理 01-打款中 02-已打款 03-打款失败
                    'repayAmtByPeriod' => '310',//每期还款总额
                    'repayCapitalByPeriod' => '300',//每期还款本金
                    'repayFeeByPeriod' => '10',//每期还款手续费
                    'transTime' => time(),//申请时间
                    'payTime' => time(),//打款时间
                    'moneylendBankName' => '招商银行',//放款银行
                ]
            ];
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '查询成功');
    }
}