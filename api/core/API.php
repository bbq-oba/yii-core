<?php

/**
 * Created by PhpStorm.
 * User: oba
 * Date: 2016/1/7
 * Time: 22:25
 */
namespace app\api\core;

use app\modules\admin\Module;
use Curl\Curl;

class API
{
    public static $defaultParam = [];
    public static function formatDate(){
        $date = \yii::$app->request->get('date',null);
        if ($date){
            if(strpos($date,',')){
                list($from,$to) = explode(',',$date);
                if($from == $to){
                    self::$defaultParam['date'] = $date;
                    self::$defaultParam['period'] = 'day';
                }else{
                    self::$defaultParam['date'] = $date;
                    self::$defaultParam['period'] = 'range';
                }
            }else{
                self::$defaultParam['date'] = $date;
                self::$defaultParam['period'] = 'day';
            }
        }else{
            self::$defaultParam['date'] = date('Y-m-d',CURRENT_TIMESTAMP);
            self::$defaultParam['period'] = 'day';
        }
        return self::$defaultParam['date'];
    }
    public static function run($method,$params = []){

        self::$defaultParam = [
            'method'=>$method,
            'module'=>'API',
            'token_auth' => STAT_API_TOKEN,
            'format'=>'JSON',
            'expanded '=>true,
            'idSite'=>1,
            'filter_offset' => \yii::$app->request->get('filter_offset',0),
            'filter_limit'  => \yii::$app->request->get('filter_limit',50)
        ];

        $params['formatDate'] = isset($params['formatDate']) ? $params['formatDate'] : null;

        if($params['formatDate'] !==false){
            self::formatDate();
        }

        unset($params['formatDate']);

        $params = array_merge(self::$defaultParam,$params);

        $params = array_filter($params);

        $curl = new Curl();

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