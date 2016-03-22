<?php

namespace app\modules\admin\helpers;

/**
 * Created by PhpStorm.
 * User: oba
 * Date: 2016/2/1
 * Time: 23:13
 */
use app\helpers\IP;
use app\helpers\IpType;
use app\modules\admin\models\ApiVisitorDetail;
use kartik\grid\GridView;
use \kartik\helpers\Html;

class StatColumns
{
    static $columns = [];
    public static function Columns1(){
        self::$columns[] =['class' => 'yii\grid\SerialColumn'];
    }
    public static function Columns2(){
        self::$columns[] =[ 'header' => '访问时间',
            'value' => function ($data) {
                return date("Y-m-d H:i:s",$data["serverTimestamp"]);
            },
        ];
    }
    public static function Columns3(){
        self::$columns[] =['header' => '唯一标识', 'value' => 'visitorId'];
    }
    public static function Columns4(){
        self::$columns[] =['header' => '访客类别',
            'value' => function ($data) {
                if ($data['visitorType'] == 'new') {
                    return '新访客';
                } else {
                    return '老访客<br />第' . $data['visitCount'] . '次访问';
                }
            },
            'format'=>'raw',
            'headerOptions'=>[
                'style'=>'width:100px;'
            ]
        ];
    }
    public static function Columns5(){
        self::$columns[] = ['header' => '访客Ip','value' => 'visitIp'];
    }
    public static function Columns6(){
        self::$columns[] =[ 'header'=>'ip归属地',
            'value'=>function($data){
                return implode(" ",IP::find($data["visitIp"]));
            },
        ];
    }
    public static function Columns7(){
        self::$columns[] =['header' => '来源', 'value' => 'referrerTypeName'];
    }
    public static function Columns8(){
        self::$columns[] =['header' => '搜索引擎',
            'format' => 'raw',
            'value' => function ($data) {
                return \kartik\helpers\Html::a($data["referrerName"], $data["referrerSearchEngineUrl"]);
            },
        ];
    }
    public static function Columns9(){
        self::$columns[] =['header' => '关键词',
            'format' => 'raw',
            'value' => function ($data) {
                return Html::a($data["referrerKeyword"], $data["referrerUrl"]);
            }
        ];
    }
    public static function Columns10(){
        self::$columns[] =['header' => '落地页Url',
            'value' => function($data){
                return $data["referrerUrl"];
            },
            'headerOptions'=>[
                'style'=>'width:300px;'
            ]
        ];
    }


    public static function ColumnsIpType()
    {
        self::$columns[] = [
            'header' => 'Ip类型',
            'value' => function($data){
                return IpType::find($data["visitIp"]);
            }
        ];
    }
    public static function getCommonUserColumns()
    {
        self::Columns1();
        self::Columns2();
        self::Columns3();
        self::Columns4();
        self::Columns5();
        self::Columns6();

        self::Columns7();
        self::Columns8();
        self::Columns9();
        self::Columns10();
        self::Columns11();
        return self::$columns;
    }

    public static function Columns11()
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
        self::$columns[] = [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',
                'buttons'=>[
                    'view'=>function ($url, $data, $key) {
                        return Html::a(Html::icon('eye-open'), \yii\helpers\Url::to([\yii::$app->controller->action->id,'visitorId'=>$data["visitorId"]]));
                    }
                ]
            ];
    }





    public static function getRegUserColumns()
    {
        self::Columns1();
        self::Columns2();
        self::Columns3();
        self::Columns4();
        self::Columns5();
        self::Columns6();
        self::ColumnsIpType();
        self::Columns7();
        self::Columns8();
        self::Columns9();

        self::$columns [] = [
            'header' => '账号',
            'value'  => 'userId',
            'filter' => GridView::TEXT
        ];
        self::$columns [] = [
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
        self::$columns [] = [
            'value' => function ($data) {
                return  isset($data['visitor_referrer']) ? ApiVisitorDetail::$referrerTypeText[$data['visitor_referrer']] : "-";
            },
            'header' => '注册点'
        ];
        self::$columns [] = [
            'value' => function ($data) {
                    return  isset($data['visitor_datatype_0']) ? $data['visitor_datatype_0'] : "";
            },
            'header' => '所属推广号'
        ];
        self::$columns [] = [
            'value' => function ($data) {
                return  isset($data['visitor_datatype_1']) ? $data['visitor_datatype_1'] : "";
            },
            'header' => '首存金额'
        ];
        self::$columns [] = [
            'value' => function ($data) {
                return  isset($data['visitor_datatype_2']) ? $data['visitor_datatype_2'] : "";
            },
            'header' => '首存优惠'
        ];
        self::$columns [] = [
            'value' => function ($data) {
                return  isset($data['visitor_datatype_3']) ? $data['visitor_datatype_3'] : "";
            },
            'header' => '存款笔数'
        ];
        self::Columns10();
        self::Columns11();
        return self::$columns;
    }

}