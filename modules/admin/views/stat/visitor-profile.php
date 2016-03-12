<?php

use kartik\helpers\Html;
use kartik\grid\GridView;
use \app\helpers\Column;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '注册用户';
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->timeZone = 'UTC';
$type = \yii::$app->request->get("type");

//$panel = '<div class="btn-group" role="group">'.
//    Html::a("普通访客", ['index'], ['class' => 'btn btn-default'.($type != 'regUser' ? ' active': '')]).
//    Html::a("注册用户", ['index','type'=>'regUser'], ['class' => 'btn btn-default'.($type == 'regUser' ? ' active': '')]).
//'</div>';
//&filter_offset=40&filter_limit=20

$panel = "";

$columns = [
    ['class' => 'yii\grid\SerialColumn'],
    //访问时间
    [
        'value' => function ($data) {
            return $data['serverDatePrettyFirstAction'] . '-' . $data['serverTimePrettyFirstAction'];
        },
        'header' => '访问时间'
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
];


?>


<div class="brand-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => \app\modules\admin\helpers\StatColumns::getRegUserColumns(),
        'pjax' => true,
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'export' => false,
        'condensed' => true,
        'hover' => true,
        'panel' => [
            'heading' => '',
            'type' => GridView::TYPE_SUCCESS,
            'before' => $panel,
            'after' => \app\helpers\Page::preNext(),
        ],
    ]); ?>

</div>
