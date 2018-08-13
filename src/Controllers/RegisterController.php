<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/8/1
 * Time: 9:54
 */

namespace Crius\Smy\Controllers;

use Crius\Smy\Helpers\RegisterHelper;
use Crius\Smy\Rules\IdNumber;
use Crius\Smy\Rules\Mobile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegisterController extends SmyController
{
    private $helper;

    public function __construct(RegisterHelper $helper)
    {
        parent::__construct();
        $this->helper = $helper;
    }

    /**
     * 注册接口
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $this->validateApi($request, ['mobilePhoneNo' => ['required', new Mobile()]]);
        return $this->helper->register($request);
    }

    /**
     * 通过验证码注册
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerByDynamicCode(Request $request)
    {
        $this->validateApi($request, [
            'mobilePhoneNo' => ['required', new Mobile()],
            'dynamicCode' => 'required'
        ], [], [
            'mobilePhoneNo' => '手机号码',
            'dynamicCode' => '验证码'
        ]);
        return $this->helper->registerByDynamicCode($request);
    }

    /**
     * 获取客户信息
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userInfo(Request $request)
    {
        return $this->helper->userInfo($request);
    }

    /**
     * 提交联系人信息
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subContactInfo(Request $request)
    {
        $this->validateApi($request, [
            'areaCode' => ['required'],
            'addressDetail' => 'required',
            'addressProvince' => 'required',
            'addressCity' => 'required',
            'addressDistrict' => 'required',
            'gpsAddress' => '',
            'gpsProvince' => '',
            'gpsCity' => '',
            'gpsDistrict' => '',
            'email' => 'required',
            'marryStatus' => 'required|in:0,1',
            'contactName' => 'required',
            'contactMobilePhoneNo' => 'required',
//            'fullContactInfoList' => 'required|json',
            'isSupplement' => 'nullable|boolean',
            'haveCreditcard' => 'required|in:0,1',
//            'educationLevel' => 'required|in:1,5,10,15,20,30,40',
        ], [], [
            'areaCode' => '地区码',
            'addressDetail' => '住址详情',
            'addressProvince' => '住址省',
            'addressCity' => '住址市',
            'addressDistrict' => '住址区',
            'gpsAddress' => 'gps住址',
            'gpsProvince' => 'gps省',
            'gpsCity' => 'gps市',
            'gpsDistrict' => 'gps区',
            'email' => '邮箱',
            'marryStatus' => '婚姻状况',
            'contactName' => '常用联系人',
            'contactMobilePhoneNo' => '常用联系人电话',
            'fullContactInfoList' => '通讯录记录',
            'isSupplement' => '补件',
            'haveCreditcard' => '是否有信用卡',
            'educationLevel' => '学历',
        ]);
        return $this->helper->subContactInfo($request);
    }

    /**
     * 提交身份证信息
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subIdInfo(Request $request)
    {
        $this->validateApi($request, [
            'name' => 'required',
//            'nation' => 'required',
            'idNo' => ['required', new IdNumber()],
//            'address' => 'required',
            'issueAgency' => 'required',
            'issueDate' => 'required|date',
            'expireDate' => 'required',
            'frontImage' => 'required|image',
            'backImage' => 'required|image',
            'isSupplement' => 'nullable|boolean',
        ], [], [
            'name' => '姓名',
            'nation' => '民族',
            'idNo' => '身份证号',
            'address' => '户口所在地',
            'issueAgency' => '签发机关',
            'issueDate' => '签发日',
            'expireDate' => '到期日',
            'frontImage' => '身份证正面照',
            'backImage' => '身份证反面照',
            'isSupplement' => '补件',
        ]);
        if ($request->get('expireDate') != '000000') {
            $this->validateApi($request, [
                'expireDate' => 'required|date',
            ], [], [
                'expireDate' => '到期日',
            ]);
        }
        return $this->helper->subIdInfo($request);
    }

    /**
     * 提交活体信息
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subLivingInfo(Request $request)
    {
        $this->validateApi($request, [
            'image_best' => 'required|image',
            'image_action1' => 'required|image',
            'image_action2' => 'required|image',
            'image_action3' => 'required|image',
            'isSupplement' => 'nullable|boolean',
        ], [], [
            'image_best' => '正面照',
            'image_action1' => '动作照1',
            'image_action2' => '动作照2',
            'image_action3' => '动作照3',
            'isSupplement' => '补件',
        ]);
        return $this->helper->subLivingInfo($request);
    }

    /**
     * 手机号认证
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subPhoneAuth(Request $request)
    {
        $this->validateApi($request, [
            'requestType' => 'nullable|in:SUB,RES',
            'dynamicCode' => 'nullable|string',
            'mobileServerPwd' => 'required|string',
            'isSupplement' => 'nullable|boolean',
        ], [], [
            'requestType' => '请求类型',
            'dynamicCode' => '动态验证码',
            'mobileServerPwd' => '服务密码',
            'isSupplement' => '补件',
        ]);
        return $this->helper->subPhoneAuth($request);
    }
}