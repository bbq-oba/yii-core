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



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'idvisitor',
                'options'=>[
                    'width'=>150
                ],
            ],
            [
                'attribute'=>'visitor_username',
                'options'=>[
                    'width'=>150
                ],
            ],
            [
                'attribute'=>'location_ip',
                'options'=>[
                    'width'=>150
                ],
            ],
            [
                'attribute'=>'info',
                'format'=>'raw',
                'options'=>[
                    'width'=>150
                ],
            ],
            [
                'attribute'=>'youhui',
                'format'=>'raw',
                'options'=>[
                    'width'=>150
                ],
            ],
//            'status',
            // 'updated_datatype_0',
            // 'updated_datatype_1',
            // 'updated_datatype_2',
            // 'updated_datatype_3',
            // 'updated_datatype_4',
            // 'updated_datatype_5',
            // 'updated_datatype_6',
            // 'updated_datatype_7',
            // 'updated_datatype_8',
            // 'updated_datatype_9',
             'iptype',
             'iptext',
            // 'updated_at',
            // 'month_cron',

            [
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
            ],
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
