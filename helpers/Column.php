<?php

/**
 * Created by PhpStorm.
 * User: oba
 * Date: 2016/1/7
 * Time: 23:47
 */
namespace app\helpers;
class Column
{
    public static function value($name){
        return [
            'value'=>$name,
            'header'=>\yii::t('column','Column'.ucfirst($name))
        ];
    }

}