<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/8/1
 * Time: 15:41
 */

namespace Crius\Smy\Controllers;


use Crius\Smy\Helpers\CardHelper;
use Crius\Smy\Rules\BankCardNumber;
use Crius\Smy\Rules\Mobile;
use Illuminate\Http\Request;

class CardController extends SmyController
{
    private $helper;

    public function __construct(CardHelper $helper)
    {
        parent::__construct();
        $this->helper = $helper;
    }

    /**
     * 获取绑定的银行卡
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCards(Request $request)
    {
        $this->validateApi($request, [
            'bankCardType' => 'required|in:0,1,2',
        ],[],[
            'bankCardType' => '银行卡类型',
        ]);
        return $this->helper->getCards($request);
    }

    /**
     * 获得银行卡预留手机动态码
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function dynamicCode(Request $request)
    {
        $this->validateApi($request, [
            'bankCardNo' => ['required',new BankCardNumber()],
            'bankCardType' => 'required|in:1,2',
            'reserveMobileNo' => ['required',new Mobile()],
        ],[],[
            'bankCardNo' => '银行卡号',
            'bankCardType' => '银行卡类型',
            'reserveMobileNo' => '银行预留手机号',
        ]);
        return $this->helper->dynamicCode($request);
    }
}