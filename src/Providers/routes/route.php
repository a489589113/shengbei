<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/8/8
 * Time: 16:08
 */

use Illuminate\Support\Facades\Route;


$namespace = 'Crius\Smy\Controllers\\';
Route::group(['prefix' => 'api/smy'],function () use ($namespace){
    /** 提交注册 */
    Route::post('register', ['uses' => $namespace.'RegisterController@index']);
    /** 判断是否已注册 */
    Route::post('users/existing', ['as' => 'Smy.users.existing', 'uses' => $namespace.'IdentityController@checkExistence']);
    /** 发送注册动码 */
    Route::post('users/regDynamicCode', ['uses' => $namespace.'IdentityController@sendRegDynamicCode']);
    /** 验证码注册 */
    Route::post('users/registerByDynamicCode', ['uses' => $namespace.'RegisterController@registerByDynamicCode']);


    Route::group(['prefix' => 'bank-cards'], function () use ($namespace) {
        /** 添加储蓄卡 */
        Route::post('addDebitCard', ['as' => 'Smy.cards.addCard', 'uses' => $namespace.'IdentityController@addDebitCard']);
        /** 添加信用卡 */
        Route::post('addCreditCard', ['as' => 'Smy.cards.addCreditCard', 'uses' => $namespace.'IdentityController@addCreditCard']);
        /** 删除银行卡 */
        Route::post('deleteCard', ['as' => 'Smy.cards.deleteCard', 'uses' => $namespace.'IdentityController@deleteCard']);
        /** 获取绑卡协议 */
        Route::post('protocols', ['uses' => $namespace.'IdentityController@getProtocols']);
        /** 获取查询银行征信提示 */
        Route::post('bank-credit-prompt', ['uses' => $namespace.'IdentityController@getBankCreditPrompt']);
    });
    /** 设置/取消自动还款 */
    Route::post('repayments/settings', ['as' => 'Smy.repayments.settings', 'uses' => $namespace.'IdentityController@setAutoRepayment']);
    /** 获取支持的分期数 */
    Route::post('installments', ['uses' => $namespace.'BusinessController@getInstallments']);
    /** 获取借款短信验证码 */
    Route::post('dynamic-codes', ['uses' => $namespace.'BusinessController@getDynamicCodes']);
    /** 获取还款短信验证码 */
    Route::post('repayments/dynamic-codes', ['uses' => $namespace.'BusinessController@getRepaymentDynamicCodes']);
    /** 获取客户信息 */
    Route::post('userInfo', ['uses' => $namespace.'RegisterController@userInfo']);
    /** 提交联系人信息 */
    Route::post('subContact', ['uses' => $namespace.'RegisterController@subContactInfo']);
    /** 提交身份证信息 */
    Route::post('subIdInfo', ['uses' => $namespace.'RegisterController@subIdInfo']);
    /** 提交活体图片信息 */
    Route::post('subLivingInfo', ['uses' => $namespace.'RegisterController@subLivingInfo']);
    /** 手机号码认证 */
    Route::post('subPhoneAuth', ['uses' => $namespace.'RegisterController@subPhoneAuth']);


    Route::group(['prefix' => 'card'],function () use ($namespace) {
        /** 获得银行卡预留手机动态码 */
        Route::post('dynamicCode', ['uses' => $namespace.'CardController@dynamicCode']);
        /** 获取绑定的银行卡 */
        Route::post('getCards', ['uses' => $namespace.'CardController@getCards']);
    });
    Route::group(['prefix' => 'loan'],function () use ($namespace) {
        /** 借款费率试算 */
        Route::post('ratesCalculate', ['uses' => $namespace.'LoanController@ratesCalculate']);
        /** 申请借款 */
        Route::post('apply', ['uses' => $namespace.'LoanController@apply']);
        /** 查询借款记录(只能查询接口成功记录) */
        Route::post('history', ['uses' => $namespace.'LoanController@successHistory']);
        /** 查询借款结果（包含失败记录） */
        Route::post('getResults', ['uses' => $namespace.'LoanController@getResults']);
    });
    Route::group(['prefix' => 'repayment'],function () use ($namespace) {
        /** 查询应还款计划 */
        Route::post('plans', ['uses' => $namespace.'RepaymentController@getPlans']);
        /**  查询还款记录 */
        Route::post('history', ['uses' => $namespace.'RepaymentController@history']);
        /** 查询还款结果 */
        Route::post('getResults', ['uses' => $namespace.'RepaymentController@getResults']);
        /** 未还清借款列表 */
        Route::post('unRepayment/loans', ['uses' => $namespace.'RepaymentController@unRepaymentLoans']);
        /** 提交还款 */
        Route::post('submit', ['uses' => $namespace.'RepaymentController@repayment']);
    });
});