<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/8/8
 * Time: 16:08
 */

Route::group(['prefix' => 'api/meizu'],function (){
    Route::post('getToken', ['uses' => 'Crius\Meizu\Controllers\MeizuController@getToken']);
    Route::post('checkToken', ['uses' => 'Crius\Meizu\Controllers\MeizuController@checkToken']);
    Route::post('getUserInfo', ['uses' => 'Crius\Meizu\Controllers\MeizuController@getUserInfo']);
    Route::post('refreshToken', ['uses' => 'Crius\Meizu\Controllers\MeizuController@refreshToken']);
});


Route::group(['prefix' => 'api/smy'],function (){
    /** 提交注册 */
    Route::post('register', ['uses' => 'RegisterController@index']);
    /** 判断是否已注册 */
    Route::post('users/existing', ['as' => 'Smy.users.existing', 'uses' => 'IdentityController@checkExistence']);
    /** 发送注册动码 */
    Route::post('users/regDynamicCode', ['uses' => 'IdentityController@sendRegDynamicCode']);
    /** 验证码注册 */
    Route::post('users/registerByDynamicCode', ['uses' => 'RegisterController@registerByDynamicCode']);


    Route::group(['prefix' => 'bank-cards'], function () {
        /** 添加储蓄卡 */
        Route::post('addDebitCard', ['as' => 'Smy.cards.addCard', 'uses' => 'IdentityController@addDebitCard']);
        /** 添加信用卡 */
        Route::post('addCreditCard', ['as' => 'Smy.cards.addCreditCard', 'uses' => 'IdentityController@addCreditCard']);
        /** 删除银行卡 */
        Route::post('deleteCard', ['as' => 'Smy.cards.deleteCard', 'uses' => 'IdentityController@deleteCard']);
        /** 获取绑卡协议 */
        Route::post('protocols', ['uses' => 'IdentityController@getProtocols']);
        /** 获取查询银行征信提示 */
        Route::post('bank-credit-prompt', ['uses' => 'IdentityController@getBankCreditPrompt']);
    });
    /** 设置/取消自动还款 */
    Route::post('repayments/settings', ['as' => 'Smy.repayments.settings', 'uses' => 'IdentityController@setAutoRepayment']);
    /** 获取支持的分期数 */
    Route::post('installments', ['uses' => 'BusinessController@getInstallments']);
    /** 获取借款短信验证码 */
    Route::post('dynamic-codes', ['uses' => 'BusinessController@getDynamicCodes']);
    /** 获取还款短信验证码 */
    Route::post('repayments/dynamic-codes', ['uses' => 'BusinessController@getRepaymentDynamicCodes']);
    /** 获取客户信息 */
    Route::post('userInfo', ['uses' => 'RegisterController@userInfo']);
    /** 提交联系人信息 */
    Route::post('subContact', ['uses' => 'RegisterController@subContactInfo']);
    /** 提交身份证信息 */
    Route::post('subIdInfo', ['uses' => 'RegisterController@subIdInfo']);
    /** 提交活体图片信息 */
    Route::post('subLivingInfo', ['uses' => 'RegisterController@subLivingInfo']);
    /** 手机号码认证 */
    Route::post('subPhoneAuth', ['uses' => 'RegisterController@subPhoneAuth']);


    Route::group(['prefix' => 'card'],function (){
        /** 获得银行卡预留手机动态码 */
        Route::post('dynamicCode', ['uses' => 'CardController@dynamicCode']);
        /** 获取绑定的银行卡 */
        Route::post('getCards', ['uses' => 'CardController@getCards']);
    });
    Route::group(['prefix' => 'loan'],function (){
        /** 借款费率试算 */
        Route::post('ratesCalculate', ['uses' => 'LoanController@ratesCalculate']);
        /** 申请借款 */
        Route::post('apply', ['uses' => 'LoanController@apply']);
        /** 查询借款记录(只能查询接口成功记录) */
        Route::post('history', ['uses' => 'LoanController@successHistory']);
        /** 查询借款结果（包含失败记录） */
        Route::post('getResults', ['uses' => 'LoanController@getResults']);
    });
    Route::group(['prefix' => 'repayment'],function (){
        /** 查询应还款计划 */
        Route::post('plans', ['uses' => 'RepaymentController@getPlans']);
        /**  查询还款记录 */
        Route::post('history', ['uses' => 'RepaymentController@history']);
        /** 查询还款结果 */
        Route::post('getResults', ['uses' => 'RepaymentController@getResults']);
        /** 未还清借款列表 */
        Route::post('unRepayment/loans', ['uses' => 'RepaymentController@unRepaymentLoans']);
        /** 提交还款 */
        Route::post('submit', ['uses' => 'RepaymentController@repayment']);
    });
})->middleware(\Crius\Smy\Middleware\SmyMiddleware::class);