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

    public function makeUrl($ref , $url)
    {
        return 'http://api.y88.ph/'.$url;
    }

    public function signUp($post, $ref)
    {
        $params['UserName'] = $post['UserName'];
        $params['Password'] = $post['Password'];
        $params['TrueName'] = $post['TrueName'];
        $params['Phone'] = $post['Phone'];
        $params['Email'] = $post['Email'];
        $params['ReferralCode'] = $post['ReferralCode'];
        $url = $this->makeUrl('', self::URL_SIGN_UP);
        return $this->signPost($url, $params);
    }

    public function checkUsername($username)
    {
        $params['userName'] = $username;
        $url = $this->makeUrl('', self::URL_CHECK_USERNAME);
        return $this->signGet($url, $params);
    }

    public function checkPhone($phone)
    {
        $params['phone'] = $phone;
        $url = $this->makeUrl('',self::URL_CHECK_PHONE);
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
        $sign = self::xmakeSign($params);
        $url = $url . '?timestamp=' . urlencode(date('Y-m-d H:i:s', CURRENT_TIMESTAMP)) . '&sign=' . $sign;
        return $this->post($url, $params);
    }

    public function signGet($url, $params)
    {
        $params = self::makeSign($params);
        return $this->get($url,$params);
    }

    //生成签名
    public static function xmakeSign($params)
    {
        $params['timestamp'] = date('Y-m-d H:i:s', CURRENT_TIMESTAMP);
        $params['secretKey'] = self::SECRET_KEY;
        $sign = md5(self::buildQuery($params));
        return $sign;
    }


}
