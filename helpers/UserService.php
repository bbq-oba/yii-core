<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/4/7
 * Time: 21:38
 */

namespace app\helpers;

use \Curl\Curl;

class UserService
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
        6 => ['会员投注信息',' api/Extension/BetAmount?userName={userName}&fromTime={fromTime}&toTime={toTime}&timestamp={timestamp}&sign={sign}'],
        7 => ['未存款之前领取的优惠',86400],
        8 => ['所有优惠',86400],
    ];


    /**
     * @param $ref int
     * @param $type int
     * @return string
     */
    public static function makeUrl($ref,$type){
        return 'http://'.self::$refEnum[$ref]['url'].'.gallary.work/'.self::$typeEnum[$type][1];
    }



    //生成签名
    public static function makeSign($params){
        $params['timestamp'] = CURRENT_TIMESTAMP;
        $params['secretKey'] = self::SECRET_KEY;
        $string = http_build_query($params);
        $params['sign'] = md5($string);
        return $params;
    }


    public static function init($ref , $type , $params){
        $url = self::makeUrl($ref,$type);
        return self::run($url,$params);
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
echo $curl->url;
        if ($curl->error) {
            return false;
        } else {
            if($curl->response === false){
                return false;
            }
            return $curl->response;
        }
    }


}