<?php

namespace Crius\Smy\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use StructuredResponse\StructuredResponse;
use Crius\Smy\Helpers\BusinessHelper;

class BusinessController extends SmyController
{
    use StructuredResponse;

    private $helper;

    public function __construct(BusinessHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * 添加信用卡
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCreditCard(Request $request)
    {
        $inputs = $request->all();
        $validate = Validator::make($inputs, [
            'bankCardNo' => 'required',
//            'bankCardType' => 'required|String|regex:/[1-2]/',
//            'mobilePhoneNo' => 'required_unless:bankCardType,2|String|regex:/^1\d{10}/',
//            'dynamicCode' => 'required_if:needValid,1|String',
            'autoRepayment' => 'required|Boolean',
            'name' => 'required',
            'idNo' => 'required'
        ]);
        $errors = $validate->errors()->all();
        if ($validate->fails()) {
            return $this->genResponse('0', $errors);
        }
        $data = array('bankId'=>'01040000', 'bankCardID'=>$inputs['bankCardNo']);
        return $this->genResponse(1, 'success', $data);
    }

    /**
     *获取支持的分期数
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInstallments(Request $request)
    {
        return $this->helper->getInstallments($request);
    }

    /**
     *获取借款验证码
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDynamicCodes(Request $request)
    {
        return $this->helper->getDynamicCodes($request);
    }

    /**
     * 获取还款验证码
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRepaymentDynamicCodes(Request $request)
    {
        $this->validateApi($request, [
            'bankCardID' => 'required|String',
            'amount' => 'required'
        ], [], [
            'bankCardID' => '银行卡ID',
            'amount' => '还款金额'
        ]);
        return $this->helper->getRepaymentDynamicCodes($request);
    }
}
