<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/3/24
 * Time: 0:36
 */

namespace app\helpers;

use \Curl\Curl;

class RegUser{
    const SIGN_KEY = '604A0B84-FBAD-4B45-AF2D-E1F848CD543F';


    public static $referrerType = [
        1 => 'lbvbet',
        2 => 'wyvbet',
    ];

    public static $referrerTypeText = [
        1 => '乐宝',
        2 => '永利汇',
    ];


    public static $typeEnum  = [
        0 => ['所属推广号',0],
        1 => ['用户首存金额',0],
        2 => ['用户首存优惠',0],
        3 => ['用户存款笔数',86400],
        4 => ['登录时间',3600],
        5 => ['成功提款次数',86400],
        6 => ['会员投注信息',43200],
        7 => ['未存款之前领取的优惠',86400],
        8 => ['所有优惠',86400],
    ];

    /**
     * @param $ref      用户注册源
     * @param $type     获取数据类型
     * @return string   请求地址
     */
    public static function getUrl($ref,$type){
        return '';
    }





    public static function get($users,$type,$ref){

        $url = 'http://'.self::$referrerType[$ref].'.gallary.work/api/user/GetUserData';

        $params = [
            'userName'=>$users, //用户名,多个用户以逗号分隔,必填
            'userDataType'=>$type, //要获取的用户数据类型,必填（所属推广号：0，用户首存金额：1，用户首存优惠：2，用户存款笔数：3）
            'signKey'=>self::SIGN_KEY, //不用修改
            'lastLoginStartTime'=>'', //最后登录开始时间,选填
            'lastLoginEndTime'=>'', //最后登录结束时间,选填
            'datatype'=>'json' //返回数据类型 xml or json
        ];

        $curl = new Curl();
        $curl->setJsonDecoder(function($response) {
            $json_obj = json_decode($response, true);
            if (!($json_obj === null)) {
                $response = $json_obj;
            }
            return $response;
        });
        $curl->get($url,$params);
        $curl->setConnectTimeout(10);
        $curl->close();
        if ($curl->error) {
            return false;
        } else {
            if($curl->response === false){
                return false;
            }
            return $curl->response;
        }
    }
    public static function getUserData($userName,$userDataType,$referrer = 1){
        $fields=array(
            'userName'=>$userName, //用户名,多个用户以逗号分隔,必填
            'userDataType'=>$userDataType, //要获取的用户数据类型,必填（所属推广号：0，用户首存金额：1，用户首存优惠：2，用户存款笔数：3）
            'signKey'=>self::SIGN_KEY, //不用修改
            'lastLoginStartTime'=>'', //最后登录开始时间,选填
            'lastLoginEndTime'=>'', //最后登录结束时间,选填
            'datatype'=>'json' //返回数据类型 xml or json
        );
        $fields=http_build_query($fields);

        $url='http://'.self::$referrerType[$referrer].'.gallary.work/api/user/GetUserData?'.$fields;
        /**
         * 不得使用 file_get_contents();
         */
        $ch=curl_init($url);

        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT, 10); //默认等待10 超时
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        $json=curl_exec($ch);
        if($json===false){
            $json=curl_error($ch);
            var_dump($json);
            die('系统报错，请修复');
        }
        curl_close($ch);
        $array=json_decode($json,true);
        return $array;
    }
}
