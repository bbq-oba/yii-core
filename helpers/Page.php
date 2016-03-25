<?php
/**
 * Created by PhpStorm.
 * User: oba
 * Date: 2016/1/30
 * Time: 0:20
 */

namespace app\helpers;


use kartik\helpers\Html;

class Page
{
    public static function preNext(){
        $offset = max(0,\yii::$app->request->get('filter_offset',0));
        $limit = \yii::$app->request->get('filter_limit',100);
        $q = \yii::$app->request->queryParams;


        $panel = '<div class="btn-group" role="group">'.
            Html::a("上一页", array_merge($q,[\yii::$app->controller->action->id,
                'filter_limit'=>$limit,
                'filter_offset'=>($offset - $limit) > 0 ? $offset - $limit : 0
            ]), ['class' => 'btn btn-default']).
            Html::a("下一页", array_merge($q,[\yii::$app->controller->action->id,
                'filter_limit'=>$limit,
                'filter_offset'=>$offset + $limit
            ]), ['class' => 'btn btn-default']).
        '</div>';
        return $panel;
    }
}
