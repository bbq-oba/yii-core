<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/4/23
 * Time: 0:15
 */

namespace app\helpers;


class SignLogic extends BaseLogic
{
    CONST URL_SIGN_UP = 'api/Extension/Regist';
    CONST URL_SIGN_IN = 'api/Extension/Login';
    const URL_CHECK_USERNAME = 'api/Extension/CheckUserName';
    const URL_CHECK_PHONE = 'api/Extension/CheckPhone';

    public function Url($url)
    {
//        return 'http://api.vbetctrl.net/'.$url;
        // return 'http://' . self::$refEnum[$ref]['url'] . '.gallary.work/' . $url;
        //return 'http://' . self::$refEnum[$ref]['url'] . '.gallary.work/' . $url;
        return 'http://api.y88.ph/'.$url;
//        return 'http://'.self::$refEnum[$ref]['url'].'.gallary.work/'.$url;
    }

    public function signUp($post, $ref)
    {


        $params['UserName'] = $post['UserName'];
        $params['Password'] = $post['Password'];
        $params['TrueName'] = $post['TrueName'];
        $params['Phone'] = $post['Phone'];
        $params['Email'] = $post['Email'];
        $params['ReferralCode'] = $post['ReferralCode'];
        $url = $this->Url( self::URL_SIGN_UP);
        return $this->signPost($url, $params);
    }

    public function checkUsername($username)
    {
        $params['UserName'] = $username;
        $url = $this->Url(self::URL_CHECK_USERNAME);
        return $this->signGet($url, $params);
    }

    public function checkPhone($phone)
    {
        $params['Phone'] = $phone;
        $url = $this->Url(self::URL_CHECK_PHONE);
        return $this->signGet($url, $params);
    }

    public function returnJsFormat($array)
    {
        if ($array['code'] != 200) {
            return ["info" => $this->$array['msg'], "status" => "n"];
        }
        return ["info" => "", "status" => "y"];
    }

    public function signIn($username, $password, $ref = 1)
    {
        $post = [
            'UserName' => $username,
            'Password' => $password
        ];
        $timestamp = date('Y-m-d H:i:s', CURRENT_TIMESTAMP);
        $sign = self::makeSign($post);

        $url = 'http://api.lb118.com/' . self::URL_SIGN_IN . '?' . http_build_query([
                'timestamp' => $timestamp,
                'sign' => $sign
            ]);

        $post['url'] = $url;
        return $post;
    }

    public function signPost($url, $params)
    {
        $sign = self::makeSign($params);
        $url = $url . '?timestamp=' . urlencode(date('Y-m-d H:i:s', CURRENT_TIMESTAMP)) . '&sign=' . $sign;
        return $this->post($url, $params);
    }

    public function signGet($url, $params)
    {
        $sign = self::makeSign($params);
        $params['timestamp'] = date('Y-m-d H:i:s', CURRENT_TIMESTAMP);
        $params['sign'] = $sign;
        $url = $url . '?' . http_build_query($params);
        return $this->get($url, []);
    }


    //生成签名
    public static function makeSign($params)
    {
        $params['timestamp'] = date('Y-m-d H:i:s', CURRENT_TIMESTAMP);
        $params['secretKey'] = self::SECRET_KEY;
        $sign = md5(self::buildQuery($params));
        return $sign;
    }


}
