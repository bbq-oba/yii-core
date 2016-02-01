<?php

namespace app\modules\admin\helpers;

/**
 * Created by PhpStorm.
 * User: oba
 * Date: 2016/2/1
 * Time: 23:13
 */
use app\helpers\IP;
use kartik\grid\GridView;
use \kartik\helpers\Html;

class StatColumns
{
    public static function getCommonColumns()
    {
        $columns = [
            ['class' => 'yii\grid\SerialColumn'],
            //访问时间
            [
                'value' => function ($data) {
                    return date("Y-m-d H:i:s",$data["serverTimestamp"]);
                },
                'header' => '访问时间',
//                'format' => ['date','Y-m-d H:i:s']
            ],
            [
                'value' => 'visitorId',
                'header' => '唯一标识'
            ],
            [
                'value' => function ($data) {
                    if ($data['visitorType'] == 'new') {
                        return '新访客';
                    } else {
                        return '老访客-第' . $data['visitCount'] . '次访问';
                    }
                },
                'header' => '访客类别'
            ],
            [
                'value' => 'visitIp',
                'header' => '访客Ip'
            ],
            [
                'value'=>function($data){
                     return implode(" ",IP::find($data["visitIp"]));
                },
                'header'=>'ip归属地'
            ],
            [
                'value' => 'referrerTypeName',
                'header' => '来源',
            ],
            [
                'format' => 'raw',

                'value' => function ($data) {
                    return \kartik\helpers\Html::a($data["referrerName"], $data["referrerSearchEngineUrl"]);
                },
                'header' => '搜索引擎名称'
            ],
            [
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data["referrerKeyword"], $data["referrerUrl"]);
                },
                'header' => '关键词'
            ],
            [
                'value' => function($data){
                    if($data['actionDetails'] && count($data['actionDetails'])){
                        $pointUrl = array_shift($data['actionDetails']);
                        return $pointUrl["url"];
                    }
                    return "";
                },
                'header' => '落地页Url',
            ]
        ];
        return $columns;
    }

    public static function getCommonUserColumns()
    {
        $columns = self::getCommonColumns();
        $columns[] = self::getCommonEndColumns();
        return $columns;
    }

    public static function getCommonEndColumns()
    {
//        $columns = [
//            'class' => '\kartik\grid\ExpandRowColumn',
//            'value' => function ($data, $key, $index) {
//                return GridView::ROW_COLLAPSED;
//            },
//            'detail' => function ($data, $key, $index, $column) {
//                return \yii::$app->controller->view->render('log-action-details', [
//                    'actions' => $data['actionDetails']
//                ]);
//            },
//        ];

        $columns =[
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',
                'buttons'=>[
                    'view'=>function ($url, $data, $key) {
                        return Html::a(Html::icon('eye-open'), \yii\helpers\Url::to([\yii::$app->controller->action->id,'visitorId'=>$data["visitorId"]]));
                    }
                ]
            ];

        return $columns;
    }

    public static function getRegUserColumns()
    {
        $columns = self::getCommonColumns();
        $columns[] = [
            'value' => 'userId',
            'header' => '注册账号'
        ];
        $columns[] = [
            'value' => function ($data) {
                if (
                    isset($data['customVariables']) && isset($data['customVariables'][1])
                    && isset($data['customVariables'][1]['customVariableName1'])
                    && $data['customVariables'][1]['customVariableName1'] == "regTime"
                    && $data['customVariables'][1]['customVariableValue1'] > 0
                ) {
                    return date("Y-m-d H:i:s", $data['customVariables'][1]['customVariableValue1']);
                } else {
                    return "";
                }
            },
            'header' => '注册时间'
        ];
//        $columns[] = self::getCommonEndColumns();
        return $columns;
    }

}