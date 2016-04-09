<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/4/7
 * Time: 21:38
 */

namespace app\helpers;

use \Curl\Curl;
use yii\base\Component;
use yii\base\Object;

class UserService extends Object
{
    public static $refEnum = [
        1=>[
            'url' => 'lbvbet',
            'txt' => '乐宝'
        ],
        2=>[
            'url' => 'wyvbet',
            'txt' => '永利汇'
        ]
    ];

    const SECRET_KEY = '604A0B84-FBAD-4B45-AF2D-E1F848CD543F';


    public static $typeEnum  = [
        0 => ['所属推广号'],
        1 => ['用户首存金额'],
        2 => ['用户首存优惠'],
        3 => ['用户存款笔数'],
        4 => ['登录时间'],
        5 => ['成功提款次数'],
        6 => ['会员投注信息'],
        7 => ['未存款之前领取的优惠'],
        8 => ['所有优惠'],
    ];


//    /**
//     * @param $ref int
//     * @param $type int
//     * @return string
//     */
    public static function makeUrl($ref,$type){
        return 'http://'.self::$refEnum[$ref]['url'].'.gallary.work/'.self::$typeEnum[$type][1];
    }

//    public static function makeUrl($ref,$type){
//        return 'http://api.vbetctrl.net/'.self::$typeEnum[$type][1];
//    }




    //生成签名
    public static function makeSign($params){
        $params['timestamp'] = date('Y-m-d H:i:s',CURRENT_TIMESTAMP);
        $params['secretKey'] = self::SECRET_KEY;
        $params['sign'] = self::buildQuery($params);

        unset($params['secretKey']);
        return $params;
    }


    public static function get($ref , $type , $params){
        $params = array_filter($params);
        $url = self::makeUrl($ref,$type);
        $params = self::makeSign($params);
        return self::run($url,$params);
    }

    public static function buildQuery($params){
        $paramsJoined = [];
        foreach($params as $param => $value) {
            $paramsJoined[] = "$param=$value";
        }
        $query = implode('&', $paramsJoined);
        return $query;
    }
    public static function run($url , $params){
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
        return self::handleResponse($curl);
    }
    public static function handleResponse($curl){
        $return = [
            'code' => 0,
            'msg'  => '',
            'data' => null,
        ];
        if ($curl->error) {
            return $return;
        } else {
            if($curl->response === false){
                return $return;
            }
            if($curl->response['StatusCode'] == 0){
                $return['code'] = 200;
            }else{
                $return['code'] = 0;
            }
            $return['msg']  = $curl->response['Message'];
            $return['data'] = $curl->response['Data'];
            return $curl->response;
        }
    }

}
