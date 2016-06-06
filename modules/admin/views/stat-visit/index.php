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
    ];
    $columns[] = [
        'attribute'=>'visitor_username',
        'options'=>[
            'width'=>150
        ],
    ];
    $columns[] = [
        'attribute'=>'location_ip',
        'options'=>[
            'width'=>150
        ],
    ];
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

    $columns[] = 'iptype';
    $columns[] = [
        'attribute'=>'viewIpText',
        'options'=>[
            'width'=>150
        ],
    ];



    $columns[] = [
        'class' => 'yii\grid\ActionColumn',
        'template'=>'{view}',
        'buttons' => [
            'view' => function ($url, $model, $key) {
                $options = [
                    'title' => Yii::t('yii', 'View'),
                    'aria-label' => Yii::t('yii', 'View'),
                    'data-pjax' => '0',
                    'target' => 'blank',
                ];
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', \yii\helpers\Url::to('/admin/stat-visit-details/?StatVisitDetailsSearch[vid]='.$model->id), $options);
            },
        ]
    ];

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
