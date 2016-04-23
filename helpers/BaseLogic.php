<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/4/17
 * Time: 15:56
 */

namespace app\helpers;


use yii\base\Object;
use Curl\Curl;

class BaseLogic extends Object
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
        0 => ['所属推广号','api/Extension/ReferralCode'],
        1 => ['用户首存金额','api/Extension/FirstDepositAmount'],
        2 => ['用户首存优惠','api/Extension/FirstDepositBonus'],
        3 => ['用户存款笔数','api/Extension/DepositCount'],
        4 => ['登录时间','api/Extension/LastLogin'],
        5 => ['成功提款次数','api/Extension/WithdrawalCount'],
        6 => ['会员投注信息',' api/Extension/BetAmount'],
        7 => ['未存款之前领取的优惠'],
        8 => ['所有优惠'],
    ];


//    /**
//     * @param $ref int
//     * @param $type int
//     * @return string
//     */
    public  function makeUrl($ref,$type){
        return 'http://'.self::$refEnum[$ref]['url'].'.gallary.work/'.$this->config[$type]['url'];
    }



    //生成签名
    public static function makeSign($params){
        $params['timestamp'] = date('Y-m-d H:i:s',CURRENT_TIMESTAMP);
        $params['secretKey'] = self::SECRET_KEY;
        $params['sign'] = md5(self::buildQuery($params));

        unset($params['secretKey']);
        return $params;
    }


    const METHOD_GET = 'get';
    const METHOD_POST = 'post';

    public function get($ref , $type , $params){
        return $this->curl($ref,$type,$params, self::METHOD_GET);
    }



    public function post($url,$params){
        $params = self::makeSign($params);
        return self::run($url,$params,self::METHOD_POST);
    }


    public function curl ($ref , $type , $params , $method){
        $params = array_filter($params,function($val){
            return $val !== null;
        });
        $url = $this->makeUrl($ref,$type);
        $params = self::makeSign($params);
        return self::run($url,$params,$method);
    }

    public static function buildQuery($params){
        $paramsJoined = [];
        foreach($params as $param => $value) {
            $paramsJoined[] = "$param=$value";
        }
        $query = implode('&', $paramsJoined);
        return $query;
    }
    public static function run($url , $params , $method){
        $curl = new Curl();
        $curl->setJsonDecoder(function($response) {
            $json_obj = json_decode($response, true);
            if (!($json_obj === null)) {
                $response = $json_obj;
            }
            return $response;
        });
        $curl->$method($url,$params);
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
            return $return;
        }
    }
}