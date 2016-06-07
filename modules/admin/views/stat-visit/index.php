<?php

use kartik\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StatVisitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '访客记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stat-visit-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?php
    $columns = [];
    $columns[] = ['class' => 'yii\grid\SerialColumn'];
    $columns[] = [
        'attribute'=>'idvisitor',
        'options'=>[
            'width'=>150
        ],
        'format'=>'raw',
        'value'=>function($data){
           return Html::a($data->idvisitor, \yii\helpers\Url::to('/admin/stat-visit-details/?StatVisitDetailsSearch[vid]='.$data->id),[
               'target'=>'_blank',
               'data-pjax'=>0
           ]);
        }
    ];
    if(!empty($searchModel->visitor_referrer)) {
        $columns[] = [
            'attribute' => 'visitor_username',
            'options' => [
                'width' => 150
            ],
        ];
    }


    if(!empty($searchModel->visitor_referrer)){
        $columns[] = [
            'attribute'=>'info',
            'format'=>'raw',
            'options'=>[
                'width'=>150
            ],
        ];
        $columns[] = [
            'attribute'=>'youhui',
            'format'=>'raw',
            'options'=>[
                'width'=>150
            ],
        ];
    }
    $columns[] = [
        'attribute'=>'location_ip',
        'options'=>[
            'width'=>150
        ],
    ];
    $columns[] = [
        'attribute'=>'viewIpText',
        'options'=>[
            'width'=>150
        ],
    ];

    $columns[] = 'count';
    $columns[] = 'current_url';
    $columns[] = 'referer_keyword';
    $columns[] = 'referer_url';
    $columns[] = 'viewLastVisitTime';

    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => $columns,
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
