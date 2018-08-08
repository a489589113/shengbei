<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/8/1
 * Time: 15:42
 */

namespace Crius\Smy\Helpers;


use Exception;
use Illuminate\Http\Request;

class RepaymentHelper extends SmyHelper
{

    /**
     * 查询应还款计划
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchPlans(Request $request)
    {
        $postField['type'] = $request->get('type', 'should');
        try {
//            $response = $this->manage->test($this->addHeaderPostField($request,$postField));
            $response = [
                [
                    'orderNo' => '12345',
                    'instalmentTotalCount' => '3',
                    'instalmentCount' => '3',
                    'bankCardNo' => '2116',
                    'bankName' => '招商银行',
                    'totalAmount' => '1010',
                    'capital' => '1000',
                    'fee' => '10',
                    'serviceChargeFee' => '0',
                    'overdueFee' => '0',
                    'interest' => '0',
                    'overdueDay' => '-1',
                    'repaymentDate' => time(),
                    'status' => '1',
                    'commissionCharge' => '10',
                    'expiryCharge' => '0',
                ], [
                    'orderNo' => '12345',
                    'instalmentTotalCount' => '3',
                    'instalmentCount' => '2',
                    'bankCardNo' => '2116',
                    'bankName' => '招商银行',
                    'totalAmount' => '1010',
                    'capital' => '1000',
                    'fee' => '10',
                    'serviceChargeFee' => '0',
                    'overdueFee' => '0',
                    'interest' => '0',
                    'overdueDay' => '-1',
                    'repaymentDate' => time(),
                    'status' => '1',
                    'commissionCharge' => '10',
                    'expiryCharge' => '0',
                ], [
                    'orderNo' => '123aaa',
                    'instalmentTotalCount' => '3',
                    'instalmentCount' => '2',
                    'bankCardNo' => '2116',
                    'bankName' => '招商银行',
                    'totalAmount' => '1010',
                    'capital' => '1000',
                    'fee' => '10',
                    'serviceChargeFee' => '0',
                    'overdueFee' => '0',
                    'interest' => '0',
                    'overdueDay' => '-1',
                    'repaymentDate' => time(),
                    'status' => '1',
                    'commissionCharge' => '10',
                    'expiryCharge' => '0',
                ],
            ];
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '查询成功');
    }

    /**
     * 查询还款记录
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function history(Request $request)
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
                        'transSeqno' => '1123211254566',//交易流水号
                        'bankCardNo' => '2116',//银行卡号（后4位）
                        'bankName' => '招商银行',//银行名
                        'repayAmt' => '1000',//还款金额
                        'repayTime' => time(),//还款时间
                        'repayStatus' => array_rand(['1', '2', '3', '6'], 1),//还款状态 ："1":"成功","2":"失败", "3":"处中,"6":"部分成功"
                        'repayResume' => '手动还款',//还款摘要 ：“自动还款”，“手动还款”
                        'repayCount' => '1',//还款笔数
                    ]
                ] //记录数据
            ];
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '查询成功');
    }

    /**
     * 查询还款结果
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
                    'transSeqno' => $transSeqNo[0],//交易流水号
                    'bankCardNo' => '2116',//银行卡号（后4位）
                    'bankName' => '招商银行',//银行名
                    'repayAmt' => '1000',//还款金额
                    'repayTime' => time(),//还款时间
                    'repayStatus' => array_rand(['1', '2', '3', '6'], 1),//还款状态 ："1":"成功","2":"失败", "3":"处中,"6":"部分成功"
                    'repayResume' => '手动还款',//还款摘要 ：“自动还款”，“手动还款”
                    'repayCount' => '1',//还款笔数
                ]
            ];
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '查询成功');
    }

    /**
     * 客户端还款计划接口
     *
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function plans(Request $request)
    {
        $response = $this->searchPlans($request);
        if ($response['retcode'] == 0) {
            return $response;
        }
        $listData = $response['data'];
        $response = [
            'total' => [
                'loanCount' => 0,
                'instalmentCount' => 0,
            ],
            'list' => $listData
        ];
        if ($listData) {
            $orders = [];
            foreach ($listData as $key => $item) {
                array_push($orders, $item['orderNo']);
                $response['total']['instalmentCount']++;
            }
            $orders = array_unique($orders);
            $response['total']['loanCount'] = sizeof($orders);
        }
        $this->clearResponse();
        return $this->parseResponse($response, '查询成功');
    }

    /**
     * 未还清借款页
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unRepaymentLoans(Request $request)
    {
        $response = $this->searchPlans($request);
        $this->clearResponse();
        if ($response['retcode'] == 0) {
            return $response;
        }
        $listData = $response['data'];
        $response = [
            'loanCount' => 0,//总未还清借款笔数
            'capitalCount' => 0,//总本金
            'feeCount' => 0,//总本金利息
            'list' => []
        ];
        if ($listData) {
            $orders = [];
//            $resultData = collect($listData)->keyBy('orderNo');
            foreach ($listData as $key => $item) {
                if (!isset($orders[$item['orderNo']])) {
                    $orders[$item['orderNo']] = [];
                }
                array_push($orders[$item['orderNo']], $item);
            }
            $response['loanCount'] = sizeof($orders);
            foreach ($orders as $order) {
                $list['unRepaymentCount'] = 0; //未还期数
                $list['capital'] = 0;//本金
                $list['fee'] = 0;//利息
                foreach ($order as $key => $item) {
                    $list['instalmentCount'] = $item['instalmentTotalCount'];//分期总数
                    $list['unRepaymentCount']++;
                    $list['capital'] += $item['capital'];//本金
                    $list['fee'] += $item['fee'];//利息

                    $response['capitalCount'] += $item['capital'];//总本金
                    $response['feeCount'] += $item['fee'];//总利息
                }
                array_push($response['list'], $list);
            }
            return $this->parseResponse($response, '查询成功');
        }
        return $this->parseResponse($response, '查询成功');
    }

    /**
     * 还款
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function repayment(Request $request)
    {
        $postField = $request->only('dynamicCode', 'bankCardID', 'amount', 'repaymentPlans');
        try {
//            $response = $this->manage->test($this->addHeaderPostField($request,$postField));
            $response = [
                'repaySeqNo' => '123456789', //当前页
                'repaymentStatus' => array_rand([1, 3], 1), //页大小
            ];
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '还款成功');
    }
}