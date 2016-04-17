<?php

use kartik\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ApiMonthDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Api Month Details');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="api-month-detail-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => '更新月份',
                'value' => function($data){
                    return $data->viewTime.$data->viewIsUpdating;
                }
            ],
            'updated_count',
            'selected_count',
            'created_at',
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' =>'{updating}',
                'buttons' =>[
                    'updating' => function ($url, $model, $key) {
                        if($model->updating->status > 0){
                            if($model->status > 0){
                                return Html::button('更新中',[
                                    'disabled'=>'disabled',
                                    'class' => 'btn btn-default'
                                ]);
                            }
                            return '';
                        }
                        return Html::a('更新',$url,[
                            'class'=>'btn btn-primary'
                        ]);
                    },
                ]
            ],
        ],
        'pjax' => true,
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'export' => [
            'fontAwesome' => true
        ],
        'condensed' => true,
        'hover' => true,
        'panel' => [
            'heading' => '',
            'type' => GridView::TYPE_SUCCESS,
            'before' => Html::a(Html::icon('plus').Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-default']),
            'after' => false,
        ],
    ]); ?>

</div>
