webpackJsonp([22,30,31],{0:function(e,t){e.exports=function(e,t,a,n){var l,i=e=e||{},o=typeof e.default;"object"!==o&&"function"!==o||(l=e,i=e.default);var u="function"==typeof i?i.options:i;if(t&&(u.render=t.render,u.staticRenderFns=t.staticRenderFns),a&&(u._scopeId=a),n){var s=Object.create(u.computed||null);Object.keys(n).forEach(function(e){var t=n[e];s[e]=function(){return t}}),u.computed=s}return{esModule:l,exports:i,options:u}}},10:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var n=a(3),l=function(e){return e&&e.__esModule?e:{default:e}}(n);t.default={name:"foot-btn-simple",data:function(){return{classname:(0,l.default)()?"f7-foot-btn-simple":""}},props:{btnTxt:{type:String,default:""},isOn:{type:Boolean,default:!1}},methods:{next:function(){this.isOn?this.$emit("next"):console.log("有信息未填完整")}}}},11:function(e,t){},12:function(e,t,a){e.exports={render:function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"foot-btn-simple",class:e.classname},[a("div",{staticClass:"foot-btn-simple_btn",class:!0===e.isOn?"foot-btn-simple_btn_on":"",on:{click:e.next}},[e._v(e._s(e.btnTxt))])])},staticRenderFns:[]},e.exports.render._withStripped=!0},122:function(e,t,a){e.exports=a.p+"images/faceverify01_eabbdec9d58139aa5d08cf5861d3ecd3.jpg"},123:function(e,t,a){e.exports=a.p+"images/faceverify02_fef147faf198b6c9430ab4eff412d3ec.jpg"},151:function(e,t,a){"use strict";function n(e){return e&&e.__esModule?e:{default:e}}var l=a(8),i=n(l),o=a(1),u=n(o),s=a(2),r=(n(s),a(42)),f=n(r);a(99);var c=a(4),d=n(c),p=a(6),_=n(p),m=a(9),y=(n(m),a(3)),h=(n(y),a(32)),b=(n(h),a(7)),v=n(b),g=a(20),k=n(g);u.default.setTitle({title:"人脸验证"}),u.default.stopLoading(),window.vue=new i.default({el:"#wrap",components:{footBtn:_.default},data:{sdk_url_res:null,btn_status:!0,bind_show:!1,img_face_01:a(122),img_face_02:a(123),tips:"正对手机开始人脸验证",userAge:0,again_show:!1,is_student:"student"==v.default.getPar("type"),is_white:"true"==v.default.getPar("is_white")},created:function(){u.default.onEventWithProperty({eventName:"page_loan_apply_verify",pageName:"loan_apply",property:{type:this.is_white?1:0}})},mounted:function(){},methods:{next:function(e){window.g=this.startBioDetectorBack,u.default.doAndroidActionWithCb("startBioDetector",JSON.stringify({}),"g")},fnbindcard:function(){(0,f.default)(function(e){e&&location.replace(d.default+"html/apply/tips.html")})},startBioDetectorBack:function(e){if(e){var t=JSON.parse(e),a={url:"api.smy.subLivingInfo",body:[{key:"image_best",value:t.image_best,type:"file"},{key:"image_action1",value:t.image_action1,type:"file"},{key:"image_action2",value:t.image_action2,type:"file"},{key:"image_action3",value:t.image_action3,type:"file"}]};u.default.startLoading(),window.sureCallback=this.sureCallback,u.default.doPostWithFiles(a,"sureCallback")}else this.again_show=!0,this.tips="验证失败，请重试"},tofilldata:function(){var e=d.default+"html/apply/fill_data.html";this.is_student&&(e=d.default+"html/apply/fill_data.html?type=student"),u.default.startPageWithCallback({url:e,start_type:1,data:"",display:{title:"填写资料"}},"vue.finishBack")},finishBack:function(){u.default.finishModule({result:!0,data:{type:"finish"}})},backApply:function(){location.replace(d.default+"html/apply/index.html")},cancel:function(){u.default.onEvent({eventName:"event_loan_face_verify_cancel",pageName:"loan_apply"}),this.finishBack()},sureCallback:function(e){u.default.stopLoading();try{if(1==JSON.parse(e).retcode){var t=v.default.getPar("dataStatus");k.default.applyStartPage(2,t,"?dataStatus="+t),u.default.finishModule()}else this.again_show=!0,this.tips="验证失败，请重试"}catch(e){this.again_show=!0,this.tips="验证失败，请重试"}}}})},18:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default={formatPhoneNum:function(e){var e=e.replace(/[^\d]/g,"");return/^86/.test(e)&&(e=e.slice(2)),e.length>11&&(e=e.slice(0,11)),e},isEmpty:function(e){return null==e||""===e}}},20:function(e,t,a){"use strict";function n(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var l=a(18),i=n(l),o=a(1),u=n(o),s=a(4),r=n(s);t.default={applyStartPage:function(e,t,a){if(console.log("curType: "+e,"dataStatus: "+t),i.default.isEmpty(e)||i.default.isEmpty(t))return console.log("1:"+i.default.isEmpty(e)),!1;var n=function(e,t){var a=null;if(i.default.isEmpty(e)||i.default.isEmpty(t))return a;for(var n=t.split(""),l=[n[0],n[1],n[3],n[4],n[2]],o=0;o<l.length;o++)if("N"===l[o]&&e<=o){a=o;break}return null==a&&(a=999),a}(e,t);console.log("index: "+n);var l=function(e,t,a){if(null==e)return null;var n=null;if(e>t)return n;switch(console.log("---------: "+t),t){case 0:n=r.default+"html/apply/identity_authentication.html";break;case 1:n=r.default+"html/apply/face_verify.html";break;case 2:n=r.default+"html/apply/mobilecarriers_verify.html";break;case 3:n=r.default+"html/apply/fill_data.html";break;case 4:n=r.default+"html/apply/bank_card_authentication.html";break;case 999:n=r.default+"html/apply/tips.html"}return i.default.isEmpty(a)||(n+=a),n}(e,n,a);console.log("url: "+l),function(e){if(i.default.isEmpty(e))return!1;var t={url:e};u.default.startPage(t)}(l)}}},32:function(e,t,a){"use strict";function n(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e){var t=i.default.getCommonInfoSync({key:"isEmulator "}),a=i.default.getCommonInfoSync({key:"sn"}),n=i.default.getCommonInfoSync({key:"imei"});!t&&a&&n&&(t="false"),u.default.ajax({data:{api_method:"api.user.whitelist.isbelong",biz_content:JSON.stringify({simulator:"true"==t?"1":"0"})},success:function(t){t.value.result?e&&e(!0,t.value.apply_way):e&&e(!1,t.value.apply_way)},complete:function(){}})};var l=a(1),i=n(l),o=a(2),u=n(o),s=a(4),r=(n(s),a(7)),f=(n(r),a(3));n(f)},42:function(e,t,a){"use strict";function n(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e,t){return new Promise(function(a,n){i.default.hideLoadingDialog(),i.default.showLoadingDialog(),u.default.ajax({data:{api_method:"api.user.account.querybindedinfo",biz_content:JSON.stringify({binded_type:"1"})},success:function(a){i.default.onEventWithProperty({eventName:"page_loan_apply_bankcard",pageName:"loan_apply",property:{type:t?1:0}}),a.value.is_binded?i.default.methodCb("startPageWithCallback",{url:"https://jr-res.meizu.com/resources/jr/"+((0,c.default)()?"flyme7":"flyme6")+"/html/mine/card_list_cp.html?business=loan_apply&partner_id=10122546566&partner_cp_type=10&bank_acc_no_index="+a.value.bank_acc_no_index+"&bank_card_last4_no="+a.value.bank_card_last4_no+"&bank_card_short_name="+a.value.bank_card_short_name+"&phone="+a.value.phone,start_type:1,data:"",display:{title:"银行卡验证"}},function(t){console.log("银行业验证-"+t),e&&e("finish"==t.type)}):i.default.methodCb("startPageWithCallback",{url:"https://jr-res.meizu.com/resources/jr/"+((0,c.default)()?"flyme7":"flyme6")+"/html/mine/card_list_cp.html?partner_id=10122546566&partner_cp_type=10&business=loan_apply",start_type:1,data:"",display:{title:"银行卡验证"}},function(t){console.log("银行业验证-"+t),e&&e("finish"==t.type)})},complete:function(){i.default.hideLoadingDialog()}})})};var l=a(1),i=n(l),o=a(2),u=n(o),s=a(4),r=(n(s),a(7)),f=(n(r),a(3)),c=n(f)},6:function(e,t,a){a(11);var n=a(0)(a(10),a(12),null,null);n.options.__file="E:\\Workspace\\vue\\crius-smyfinancial-h5\\src\\component\\foot-btn-simple\\foot-btn-simple.vue",n.esModule&&Object.keys(n.esModule).some(function(e){return"default"!==e&&"__esModule"!==e})&&console.error("named exports are not supported in *.vue files."),n.options.functional&&console.error("[vue-loader] foot-btn-simple.vue: functional components are not supported with templates, they should use render functions."),e.exports=n.exports},9:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(){l.default.addHomePressedListener("back")};var n=a(1),l=function(e){return e&&e.__esModule?e:{default:e}}(n);window.back=function(){for(var e=document.querySelectorAll("input"),t=0;t<e.length;t++)e[t].blur();setTimeout(function(){l.default.finishModule({result:!0,data:{type:"back"}})},200)}},99:function(e,t){}},[151]);