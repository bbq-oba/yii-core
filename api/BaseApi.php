<?php

/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/4/20
 * Time: 22:34
 */
class BaseApi extends \yii\base\Object
{


    const STAT_API_URL = 'http://p.sasa8.com/index.php';
    const STAT_API_TOKEN = 'c38de7c5e14711949af48b11464d8cba';

    public static $default = [
        'module'=>'API',
        'token_auth' => self::STAT_API_TOKEN,
        'format'=>'JSON',
        'expanded '=>true,
        'idSite'=>1,
    ];

    public $params = [];
    public function init()
    {
        $params = array_merge(self::$default,$this->params);
        return $this->run($params);
    }






    public static function run($params){

        $curl = new \Curl\Curl();
        $curl->setJsonDecoder(function($response) {
            $json_obj = json_decode($response, true);
            if (!($json_obj === null)) {
                $response = $json_obj;
            }
            return $response;
        });

        $curl->get(STAT_API_URL,$params);
        $curl->close();

        if ($curl->error) {
            echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage;
        } else {
            return $curl->response;
        }
    }
}