<?php

use kartik\helpers\Html;
use kartik\grid\GridView;
use \app\helpers\Column;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '所有来源';
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->timeZone = 'UTC';
$view = $this;
?>
<div class="brand-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => '\kartik\grid\ExpandRowColumn',
                'value'=>function ($data, $key, $index) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail'=>function ($data, $key, $index , $column) {
                    return $this->render('log-action-details',[
                        'actions'=>$data['actionDetails']
                    ]);
                },
            ],
            [
                'value' => function($data){
                    return $data['serverDatePrettyFirstAction'].'-'.$data['serverTimePrettyFirstAction'];
                }
            ],
            [
                'value' => 'visitIp',
                'header' =>'访客Ip'
            ],
            [
                'value'=>'referrerTypeName',
                'header'=>'来源',
            ],

            [
                'value'=> 'location',
                'header'=>'来自'
            ],
            [
                'value' => 'userId',
                'header' => '账号'
            ],
            [
                'value' =>function($data){
                    return $data['actions'].'次'.$data['visitDurationPretty'];
                },
            ],
            [
                'value' => function($data){
                    if($data['visitorType'] == 'new'){
                        return '新访客';
                    }else{
                        return '老访客-第'.$data['visitCount'].'次访问';
                    }
                },
                'header'=>'访客类别'
            ]
//            ['value'=>'label', 'header'=>'来源类型'],
//            ['value'=>'nb_visits', 'header'=>'访问次数'],
//            ['value'=>'nb_actions', 'header'=>'活动次数'],
//            ['value'=>'bounce_count', 'header'=>'跳出次数'],
//            [
//                'value'=>function($data){
//                    $time = yii::$app->formatter->asDate(round($data['sum_visit_length'] / $data['nb_visits']),'H:i:s');
//                    return $time.'秒';
//                },
//                'header'=>'平均停留时间',
//            ],
//            [
//                'value'=>function($data){
//                    return yii::$app->formatter->asDecimal($data['nb_actions'] / $data['nb_visits'],2).'秒';
//                },
//                'header'=>'平均活动次数',
//            ],

        ],
        'pjax' => true,
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'export' => false,
        'condensed' => true,
        'hover' => true,
        'panel' => [
            'heading' => '',
            'type' => GridView::TYPE_SUCCESS,
            'before' => false,
            'after' => false,
        ],
    ]); ?>

</div>
