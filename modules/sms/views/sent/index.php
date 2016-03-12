<?php

use kartik\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\sms\models\SentSmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sent Sms');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sent-sms-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'SmsIndex',
            'PhoneNumber',
            'SmsContent',
//            'SmsTime',

//            [
//                'attribute' => 'SmsTime',
//                'value' => 'SmsTime',
//                'filter' => \kartik\date\DatePicker::widget([
//                    'name' => 'SmsTime',
//                    'value' => date('d-M-Y', strtotime('+2 days')),
//                    'options' => ['placeholder' => 'Select issue date ...'],
//                    'pluginOptions' => [
//                        'format' => 'dd-M-yyyy',
//                        'todayHighlight' => true
//                    ]
//                ]),
//                'format' => 'html',
//            ],

            [
                'attribute' => 'SmsTime',
                'filter' => \kartik\daterange\DateRangePicker::widget([
                    'attribute'=>"SmsTime",
                    'model'=>$searchModel,
//                    'value'=>'date(Y-m-d) 至 date(+2 days)',
                    'convertFormat'=>true,
//                    'useWithAddon'=>true,
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
            ],





            'SmsUser',
             [
                 'attribute' =>'Status',
//                 'filterType' => GridView::FILTER_SELECT2,
                 'filter' => \app\modules\sms\models\SentSms::$statusEnum,
                 'filterWidgetOptions' => [
                     'pluginOptions' => ['allowClear' => true],
                 ],
                 'value' => 'viewStatus',
                 'format' => 'raw'
             ],
            // 'NewFlag',
            // 'UserDefineNo',
             'SentSetIndex',
            // 'RM1',
            // 'RM2',
            // 'RM3',
            // 'RecvReportTime',

//            ['class' => 'yii\grid\ActionColumn'],
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
