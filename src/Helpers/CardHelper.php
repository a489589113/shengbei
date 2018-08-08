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

class CardHelper extends SmyHelper
{
    /**
     * 获得银行卡预留手机动态码
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function dynamicCode(Request $request)
    {
        $postField = $request->only('bankCardNo', 'bankCardType', 'reserveMobileNo');
        try {
//            $response = $this->manage->test($this->addHeaderPostField($request,$postField));
            $response = null;
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '获取成功');
    }

    /**
     * 获取绑定的银行卡
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCards(Request $request)
    {
        $postField = $request->only('bankCardType');
        try {
//            $response = $this->manage->test($this->addHeaderPostField($request,$postField));
            $depositCard=[
                [
                    'bankCardID'=>'2',
                    'bankCardNo'=>'2116',
                    'bankCardType'=>'1',
                    'autoRepayment'=>true,
                    'bankID'=>'03080000',
                    'bankName'=>'招商银行',
                ]
            ];
            $creditCard=[
                [
                    'bankCardID'=>'1',
                    'bankCardNo'=>'0468',
                    'bankCardType'=>'2',
                    'autoRepayment'=>false,
                    'bankID'=>'03010000',
                    'bankName'=>'交通银行',
                ]
            ];
            $response=[];
            switch ($postField['bankCardType']){
                case 0:
                    $response = array_merge($depositCard,$creditCard);
                    break;
                case 1:
                    $response=$depositCard;
                    break;
                case 2:
                    $response=$creditCard;
                    break;
            }
            $bankConfig=config('smySupportBank');
            foreach ($response as $key=>$item){
                if (!isset($bankConfig[$item['bankID']])){
                    $response[$key]['bankLogo']=$bankConfig[$item['bankID']]['bankLogo'];
                    $response[$key]['bankColor']=$bankConfig[$item['bankID']]['bankColor'];
                    $response[$key]['bankColorEnd']=$bankConfig[$item['bankID']]['bankColorEnd'];
                }else{
                    $response[$key]['bankLogo']=$bankConfig[$item['bankID']]['bankLogo'];
                    $response[$key]['bankColor']=$bankConfig[$item['bankID']]['bankColor'];
                    $response[$key]['bankColorEnd']=$bankConfig[$item['bankID']]['bankColorEnd'];
                }
            }
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '获取成功');
    }
}