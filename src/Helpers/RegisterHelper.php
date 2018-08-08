<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/8/1
 * Time: 11:30
 */

namespace Crius\Smy\Helpers;


use Crius\Smy\Manager\SmyManager;
use Exception;
use Illuminate\Http\Request;
use Crius\Smy\Models\UserOpenId;

class RegisterHelper extends SmyHelper
{
    private $userOpenId;

    public function __construct(SmyManager $manage, UserOpenId $userOpenId)
    {
        parent::__construct($manage);
        $this->userOpenId = $userOpenId;
    }

    /**
     * 注册接口
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $addField = $request->only('mobilePhoneNo');
        $addField['openId'] = $this->getOpenId($request);
        $postField = $request->only('mobilePhoneNo');
        try {
//            $response = $this->manage->userRegister($this->addHeaderPostField($request,$postField));
            $this->add($addField);
            $response = ['custNo' => '123123'];
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '注册成功');
    }

    /**
     * 通过验证码注册
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerByDynamicCode(Request $request)
    {
        $addField = $request->only('mobilePhoneNo');
        $addField['openId'] = $this->getOpenId($request);
        $postField = $request->only('mobilePhoneNo', 'dynamicCode');
        try {
//            $response = $this->manage->registerByDynamicCode($this->addHeaderPostField($request, $postField));
            $this->add($addField);
            $response = ['custNo' => '123123'];
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '注册成功');
    }

    /**
     * 查询获取客户信息
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userInfo(Request $request)
    {
        $openId = $this->getOpenId($request);
        $record = $this->exist($openId);
        try {
//            if (isset($record->mobilePhoneNo)&&$record->mobilePhoneNo){
//                $response = $this->manage->userInfo($this->addHeaderPostField($request));
//            }else{
//                $response = null;
//            }
            //信用额度
            $creditLimit = 10000;
            //可用额度
            $availableLimit = 9000;
            //等级描述
            $custLevelDesc = '享信用卡日利率0.5‰的';
            //等级折扣
            $custLevelDiscount = '9.8折';
            //授信状态
            //"0":授信中
            //"1":授信通过
            //"2":资料不全
            //"3":授信不通过
            //"4":需要补件
            $grantingStatus = array_rand([0, 1, 2, 3, 4], 1);
            //资料完成进度 "YNNYY",不同位表示不同的授信项,标示状态顺序依次为:身份证、活体检测、绑定借记卡、手机号认证、联系人信息
            $dataStatus = 'YYYYY';
            //汇总还款信息
            $totalRepaymentInfo = [
                'totalAmount' => 1021,//总金额，最近要还的金额 总金额=本金+逾期费用+利息
                'capital' => 1000,//本金
                'overdueFee' => 0,//逾期费用
                'interest' => 21,//利息
                'overdueDay' => -10,//逾期天数（正或者负，正表示已逾期，负表示还款倒计时天数）
                'type' => 2,//应还款类型("1":已逾期,"2":未逾期,近期应还款,"3":未逾期,当天应还款)
                'all' => 1021,//全部待还金额
            ];
            //哪步是否要补件，按身份证、活体检测、绑定借记卡、手机号认证、联系人信息顺序显示是否需要补件及补件原因
            $supplementInfos = [
                ['needSupplement' => false, 'reason' => ''],
                ['needSupplement' => false, 'reason' => ''],
                ['needSupplement' => false, 'reason' => ''],
                ['needSupplement' => false, 'reason' => ''],
                ['needSupplement' => false, 'reason' => ''],
            ];

            if ($this->exist($openId)) {
                $response = [
                    'mobilePhoneNo' => '13590919341',
                    'creditLimit' => $creditLimit,
                    'availableLimit' => $availableLimit,
                    'custLevelDesc' => $custLevelDesc,
                    'custLevelDiscount' => $custLevelDiscount,
                    'grantingStatus' => $grantingStatus,
                    'dataStatus' => $dataStatus,
                    'totalRepaymentInfo' => $totalRepaymentInfo,
                    'supplementInfos' => $supplementInfos,
                ];
            } else $response = null;

        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '获取成功');
    }

    /**
     * 提交联系人信息
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subContactInfo(Request $request)
    {
        $postField = $request->only(['areaCode', 'addressDetail', 'addressProvince', 'addressCity', 'addressDistrict', 'gpsAddress',
            'gpsProvince', 'gpsCity', 'gpsDistrict', 'email', 'fullContactInfoList', 'appInfoList', 'educationLevel']);
        $postField['marryStatus'] = $request->get('marryStatus') ? 20 : 10;
        $postField['haveCreditcard'] = $request->get('haveCreditcard') ? 'Y' : 'N';
        $postField['isSupplement'] = $request->get('isSupplement') ? true : false;
        $postField['immediateContact'] = [
            'name' => $request->get('contactName'),
            'mobilePhoneNo' => $request->get('contactMobilePhoneNo')
        ];
        try {
//            $response = $this->manage->test($this->addHeaderPostField($request,$postField));
            $response = null;
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '提交成功');
    }

    /**
     * 提交身份证信息
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subIdInfo(Request $request)
    {
        $postField['idInfo'] = $request->only(['name', 'nation', 'idNo', 'address', 'issueAgency', 'issueDate', 'expireDate', 'frontImage', 'backImage']);
        $idCard = new Idcard();
        $postField['idInfo'] ['sex'] = $idCard->getChinaIDCardSex($postField['idNo']);
        $postField['isSupplement'] = $request->get('isSupplement') ? true : false;
        try {
//            $response = $this->manage->test($this->addHeaderPostField($request,$postField));
            $response = null;
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '提交成功');
    }

    /**
     * 提交活体信息
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subLivingInfo(Request $request)
    {

        try {
//            $livingImageList = $request->get('livingImageList');
//            $livingImageList = json_decode($livingImageList, true);
//            $liveArr = [];
//            array_push($liveArr, $livingImageList['image_best']);
//            array_push($liveArr, $livingImageList['image_action1']);
//            array_push($liveArr, $livingImageList['image_action2']);
//            array_push($liveArr, $livingImageList['image_action3']);
//            $postField['livingInfo']['livingImageList'] = $liveArr;
//            $postField['isSupplement'] = $request->get('isSupplement') ? true : false;
//            $response = $this->manage->test($this->addHeaderPostField($request,$postField));
            $response = null;
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '提交成功');
    }

    /**
     * 手机号认证
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subPhoneAuth(Request $request)
    {
        $postField = $request->only('requestType', 'dynamicCode', 'mobileServerPwd');
        $postField['isSupplement'] = $request->get('isSupplement') ? true : false;
        try {
//            $response = $this->manage->test($this->addHeaderPostField($request,$postField));
            $response = [
                'status' => array_rand(['01', '02', '05', '04', '08'], 1),
                'content' => '此处是提示'
            ];
        } catch (Exception $exception) {
            return $this->returnResp(false, $exception->getMessage());
        }
        return $this->parseResponse($response, '提交成功');
    }

    public function add($params)
    {
        $userOpenId = new UserOpenId();
        $userOpenId->openId = $params['openId'];
        $userOpenId->mobilePhoneNo = $params['mobilePhoneNo'];
        $userOpenId->save();
    }

    public function exist($openId)
    {
        return UserOpenId::where('openId', $openId)->first();
    }
}