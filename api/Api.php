<?php

/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/4/20
 * Time: 23:24
 */
class Api extends BaseApi
{

    public static function getL(){

        $model  = new \app\modules\admin\models\VisitsDetails();

        

        $params = [];
        $params['method'] = 'Live.getLastVisitsDetails';





        return (new BaseApi($params));
    }




}