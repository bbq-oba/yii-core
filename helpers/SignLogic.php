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
        return 'http://'.self::$refEnum[$ref]['url'].'.gallary.work/'.$url;
    }
    public function signUp($post,$ref){
        $url = $this->makeUrl($ref,self::URL_SIGN_UP);
        return $this->post($url,$post);
    }

}