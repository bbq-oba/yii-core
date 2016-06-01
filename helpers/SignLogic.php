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


    public function makeUrl($ref, $url)
    {
//        return 'http://api.vbetctrl.net/'.$url;
        return 'http://' . self::$refEnum[$ref]['url'] . '.gallary.work/' . $url;
        return 'http://www.y88.ph/api/Account/Regist';
//        return 'http://'.self::$refEnum[$ref]['url'].'.gallary.work/'.$url;
    }

    public function signUp($post, $ref)
    {

        $params['UserName'] = $post['UserName'];
        $params['Password'] = $post['Password'];
        $params['TrueName'] = $post['TrueName'];
        $params['Phone'] = $post['Phone'];
        $params['Email'] = $post['Email'];
        $params['ExtendCode'] = $post['ExtendCode'];

        $url = $this->makeUrl($ref, self::URL_SIGN_UP);
        return $this->signPost($url, $params);
    }

    public function signIn($username , $password, $ref = 1)
    {
        $post = [
            'UserName' => $username,
            'Password' => $password
        ];
        $timestamp = date('Y-m-d H:i:s', CURRENT_TIMESTAMP);
        $sign = self::makeSign($post);

        $url = 'http://api.lb118.com/'. self::URL_SIGN_IN . '?' . http_build_query([
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


    //生成签名
    public static function makeSign($params)
    {
        $params['timestamp'] = date('Y-m-d H:i:s', CURRENT_TIMESTAMP);
        $params['secretKey'] = self::SECRET_KEY;
        $sign = md5(self::buildQuery($params));
        return $sign;
    }


}