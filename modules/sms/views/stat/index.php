<?php

use kartik\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\sms\models\SentSmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "发送统计";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sent-sms-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            [
                'attribute' => 'SmsTime',
                'filter' => \kartik\daterange\DateRangePicker::widget([
                    'attribute'=>"SmsTime",
                    'model'=>$searchModel,
                    'convertFormat'=>true,
                    'pluginOptions'=>[
                        'locale'=>[
                            'separator'=>' 至 ',
                            'format'=>'Y-m-d'
                        ],
                        'format' => 'dd-M-yyyy',
                        'opens'=>'left'
                    ]
                ]),
                'format' => 'html',
                'header'=>'日期',
                'headerOptions'=>[
                    'width'=>210
                ],
                'value'=>function($data){
                    return $data['date'];
                }
            ],
            [
                'header'=>'发送成功数',
                'value'=>function($data){
                    return $data['succeed'];
                }
            ],
            [
                'header'=>'发送失败数',
                'value'=>function($data){
                    return $data['all'] - $data['succeed'];
                }
            ],
            [
                'header'=>'发送总数',
                'value'=>function($data){
                    return $data['all'];
                }
            ],
        ],
        'pjax' => false,
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'autoXlFormat'=>true,
        'export'=>[
            'fontAwesome'=>true,
            'showConfirmAlert'=>false,
            'target'=>GridView::TARGET_BLANK
        ],
        'exportConfig'=> [
            GridView::EXCEL => 'excel'
        ],
        'condensed' => true,
        'hover' => true,
        'panel' => [
            'heading' => '',
            'type' => GridView::TYPE_SUCCESS,
            'before' => "",
            'after' => false,
        ],
    ]); ?>

</div>
