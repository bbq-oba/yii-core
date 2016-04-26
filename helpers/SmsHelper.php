<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/4/24
 * Time: 23:53
 */

namespace app\helpers;


use app\api\yunpian\SmsOperator;
use app\models\CaptchaCode;

class SmsHelper
{

    public static function send($mobile)
    {

        $session = \yii::$app->session;
        $sessionKey = 'LIMIT_REQUEST';

        $sessionValue = $session->get($sessionKey);
        $sessionLimit = 5;

        $time = CURRENT_TIMESTAMP - $sessionValue;

        if (empty($sessionValue) || ($sessionValue && $time > $sessionLimit)) {
            $session->set($sessionKey, CURRENT_TIMESTAMP);

            $code = rand(10000, 99999);
            $sms = new SmsOperator();
            $content = '【乐宝娱乐】您的验证码：' . $code . '，官网网址：http://79333.net';
//            $send = $sms->single_send([
//                'mobile'=>$mobile,
//                'text'=>$content
//            ]);
//            ll->statusCode = 200;
            if (1) {
                //$send->statusCode == 200){
                CaptchaCode::insertCode($mobile, $code, $content);
                return ['code'=>200, 'msg'=>'ok'];
            }
            return ['code'=>201, 'msg'=>'send failed'];
        } else {
            return ['code'=>202, 'msg'=>'请等待' . ($sessionLimit - $time) . '秒'];
        }


    }

    public static function check($mobile, $code)
    {


        $model = CaptchaCode::find()->where([
            'mobile' => $mobile,
            'status' => 0
        ])->andWhere($and)->orderBy('created_at desc')->one();

        if (empty($model)) {
            return false;
        }
        if ($model->code != $code) {
            return false;
        }
        return $model;
    }


}