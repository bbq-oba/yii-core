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
    public static function run($method,$params = []){
        $defaultParam = [
            'method'=>$method,
            'module'=>'API',
            'token_auth' => STAT_API_TOKEN,
            'format'=>'JSON',
            'expanded '=>true,
            'idSite'=>\yii::$app->session['idSite'],
            'period'=>\yii::$app->session['period'],
            'date'=>\yii::$app->session['date'],
        ];
        $params = array_merge($defaultParam,$params);

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