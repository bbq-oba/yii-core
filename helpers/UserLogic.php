<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/4/7
 * Time: 22:32
 */

namespace app\helpers;


class UserLogic extends UserService
{





    public static function getApiType0($userName,$ref){
        $params['userName'] = $userName;
        return UserService::init($ref,0,$params);
    }

    public static function getApiType1($userName,$ref){
        $params['userName'] = $userName;
        return UserService::init($ref,1,$params);
    }
    public static function getApiType3($userName,$ref){
        $params['userName'] = $userName;
        return UserService::init($ref,3,$params);
    }

    public static function getApiType6($userName,$ref,$fromTime,$toTime){
        $params['userName'] = $userName;
        $params['fromTime'] = $fromTime;
        $params['toTime'] = $toTime;
        return UserService::init($ref,6,$params);
    }



}