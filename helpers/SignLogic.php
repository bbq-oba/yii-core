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


    public function signIn(){

    }
    CONST URL_SIGN_UP = 'api/Extension/Regist';
    CONST URL_SIGN_IN = 'api/Extension/Regist';


    public  function makeUrl($ref,$url){
        return 'http://api.vbetctrl.net/'.$url;
        return 'http://'.self::$refEnum[$ref]['url'].'.gallary.work/'.$url;
//        return 'http://'.self::$refEnum[$ref]['url'].'.gallary.work/'.$url;
    }
    public function signUp($post,$ref){
        $url = $this->makeUrl($ref,self::URL_SIGN_UP);
        return $this->signPost($url,$post);
    }

    public function signPost($url,$params){
        $sign = self::makeSign($params);
        $url = $url.'?timestamp='.urlencode(date('Y-m-d H:i:s',CURRENT_TIMESTAMP)).'&sign='.$sign;
echo $url."<br />";
        print_r($params);
        return $this->post($url,$params);
    }


    //生成签名
    public static function makeSign($params){
        $params['timestamp'] = date('Y-m-d H:i:s',CURRENT_TIMESTAMP);
        $params['secretKey'] = self::SECRET_KEY;
        $sign = md5(self::buildQuery($params));
        return $sign;
    }



}