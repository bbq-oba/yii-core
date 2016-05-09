<?php

namespace app\helpers;

/**
 * Created by PhpStorm.
 * User: oba
 * Date: 2016/2/1
 * Time: 23:13
 */
use app\helpers\IP;
use app\helpers\IpType;
use app\helpers\RegUser;
use app\helpers\UserLogic;
use app\helpers\UserService;
use app\models\ApiVisitorConfig;
use app\modules\admin\models\ApiVisitorDetail;
use kartik\grid\GridView;
use \kartik\helpers\Html;

class StatColumns
{
    static $columns = [];

    public static function Columns1()
    {
        self::$columns[] = ['class' => 'yii\grid\SerialColumn'];
    }

    public static function Columns2()
    {
        self::$columns[] = ['header' => '访问时间',
            'value' => function ($data) {
                return isset($data["serverTimestamp"]) ? date("Y-m-d H:i:s", $data["serverTimestamp"]) : '';
            },
        ];
    }

    public static function Columns3()
    {
        self::$columns[] = ['header' => '唯一标识', 'value' => 'visitorId'];
    }

    public static function Columns4()
    {
        self::$columns[] = [
            'header' => '访问次数',
            'value' => 'actions'
        ];


//        self::$columns[] = ['headear' => '访客类别',
//            'value' => function ($data) {
//                if ($data['visitorType'] == 'new') {
//                    return '新访客';
//                } else {
//                    return '老访客<br />第' . ($data['visitCount']+1) . '次访问';
//                }
//            },
//            'format' => 'raw',
//            'headerOptions' => [
        //               'style' => 'width:100px;'
        //          ]
        //       ];
    }

    public static function Columns5()
    {
        self::$columns[] = ['header' => '访客Ip', 'value' => 'visitIp'];
    }

    public static function Columns6()
    {
        self::$columns[] = ['header' => 'ip归属地',
            'value' => function ($data) {
                return isset($data['visitIp']) ? implode(" ", IP::find($data["visitIp"])) : '';
            },
        ];
    }

    public static function Columns7()
    {
        self::$columns[] = ['header' => '关键词', 'value' => 'referrerKeyword'];

    }

    public static function Columns8()
    {
        self::$columns[] = [
            'header' => '来源url',
            'format' => 'raw',
            'value' => function ($data) {
                return isset($data['referrerUrl']) ? ('<div style="width: 300px; overflow: hidden;">' . $data['referrerUrl'] . '</div>') : '';

            },
        ];
    }

    public static function Columns9()
    {
//        self::$columns[] =['header' => '关键词',
//            'format' => 'raw',
//            'value' => function ($data) {
//                return Html::a(, $data["referrerUrl"]);
//            }
//        ];
    }

    public static function Columns10()
    {
        self::$columns[] = ['header' => '落地页Url',
            'format' => 'raw',
            'value' => function ($data) {
                if (isset($data['actionDetails']) && $data['actionDetails'] && count($data['actionDetails'])) {
                    $pointUrl = array_shift($data['actionDetails']);
                    return '<div style="width: 300px; overflow: hidden;">' . $pointUrl["url"] . '</div>';
                }
                return "";
            },
            'options' => [
                'style' => 'width:300px; overflow:hidden;'
            ]
        ];
    }


    public static function ColumnsIpType()
    {
        self::$columns[] = [
            'header' => 'Ip类型',
            'value' => function ($data) {
                return $data['iptype'];
            }
        ];
    }

    public static function getCommonUserColumns()
    {
        self::Columns1();
        self::$columns[] = [
            'header' => 'id',
            'value' => 'idVisit',
        ];
        self::$columns [] = [
            'header' => '账号',
            'value' => 'userId',
            'filter' => GridView::TEXT
        ];
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
        self::$columns[] = ['header' => '',
            'value' => function ($data) {
                return '';
            }
        ];
    }

    public static function getRegUserColumns()
    {
        self::Columns1();
        self::$columns[] = [
            'header' => 'id',
            'value' => 'idVisit',
        ];
        self::Columns2();
        self::Columns3();
        self::Columns4();
        self::Columns5();
        self::$columns[] = ['header' => 'ip归属地',
            'value' => function ($data) {
                return $data['iptext'];
            },
        ];


//        self::ColumnsIpType();
        self::Columns7();
        self::Columns8();
        self::Columns9();

        self::$columns [] = [
            'header' => '账号',
            'value' => 'userId',
            'filter' => GridView::TEXT
        ];
        //self::$columns [] = [
        //    'value' => function ($data) {
        //        return  isset($data['visitor_referrer']) ? ApiVisitorDetail::$referrerTypeText[$data['visitor_referrer']] : "-";
        //    },
        //    'header' => '注册点'
        //];

        // 0

        self::$columns [] = [
            'value' => function ($data) {
                $regTime = "";
                if (
                    isset($data['customVariables']) && isset($data['customVariables'][1])
                    && isset($data['customVariables'][1]['customVariableName1'])
                    && $data['customVariables'][1]['customVariableName1'] == "regTime"
                    && $data['customVariables'][1]['customVariableValue1'] > 0
                ) {
                    $regTime = date("Y-m-d H:i:s", $data['customVariables'][1]['customVariableValue1']);
                }
                $array = [];

                $regText = in_array($data['visitor_referrer'], array_keys(UserLogic::$refEnum)) ? UserLogic::$refEnum[$data['visitor_referrer']]['txt'] : "-";
                $array[] = sprintf("注册时间:%s", $regTime);
                $array[] = sprintf("注册来源:%s", $regText);
                $array[] = sprintf("注册网址:%s", $data['visitor_datatype_9']);
                $array[] = sprintf("代理　号:%s", $data['visitor_datatype_0']);
                $array[] = sprintf("首存金额:%s", $data['visitor_datatype_1']);
                $array[] = sprintf("存款次数:%s", $data['visitor_datatype_3']);
                return '<div style="width:200px">' . implode("<br />", $array) . '</div>';
            },
            'header' => '推广信息',
            'format' => 'raw',

        ];
//        self::$columns [] = [
//            'value' => function ($data) {
//                return $data['visitor_datatype_1'];
//            },
//            'header' => ApiVisitorConfig::cache()
//        ];
//        self::$columns [] = [
//            'value' => function ($data) {
//                return  $data['visitor_datatype_2'];
//            },
//            'header' => UserService::$typeEnum[2][0]
//        ];
        self::$columns [] = [
            'value' => function ($data) {
                return $data['visitor_datatype_2'];
            },
            'header' => '首存优惠'
        ];
        self::$columns [] = [
            'value' => function ($data) {
                return $data['visitor_datatype_5'];
            },
            'header' => '提款次数'
        ];
        self::$columns [] = [
            'value' => function ($data) {
                $array = [];
                $array[] = sprintf("次数:%s", $data['visitor_datatype_7']);
                $array[] = sprintf("金额:%s", $data['visitor_datatype_8']);
                return implode("<br />", $array);
            },
            'header' => '未存款优惠',
            'format' => 'raw'
        ];

//        self::$columns [] = [
//            'value' => function ($data) {
//                return  $data['visitor_datatype_4'];
//            },
//            'header' => UserService::$typeEnum[4][0]
//        ];
//        self::$columns [] = [
//            'value' => function ($data) {
//                return  $data['visitor_datatype_5'];
//            },
//            'header' => UserService::$typeEnum[5][0]
//        ];
//        self::$columns [] = [
//            'value' => function ($data) {
//                return  $data['visitor_datatype_6'];
//            },
//            'header' => UserService::$typeEnum[6][0]
//        ];
//        self::$columns [] = [
//            'value' => function ($data) {
//                return  $data['visitor_datatype_7'];
//            },
//            'header' => UserService::$typeEnum[7][0]
//        ];
//        self::$columns [] = [
//            'value' => function ($data) {
//                return  $data['visitor_datatype_8'];
//            },
//            'header' => UserService::$typeEnum[8][0]
//        ];


        self::$columns [] = [
            'value' => function ($data) {
                return $data['visitor_datatype_4'] ? date('Y-m-d H:i:s', strtotime($data['visitor_datatype_4']) + 43200) : null;
            },
            'header' => '最后登陆'
        ];


        self::Columns10();
        self::Columns11();
        return self::$columns;
    }

}
