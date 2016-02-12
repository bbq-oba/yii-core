<?php

use kartik\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\sms\models\SendingSmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sending Sms');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sending-sms-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'SmsIndex',
            'SmsUser',
            'PhoneNumber',
            'SmsContent',
            'UserDefineNo',
            // 'PutInType',
            // 'SendLevel',
            // 'SendModem',
            // 'NewFlag',
            // 'RM1',
            // 'RM2',
            // 'RM3',

            ['class' => 'yii\grid\ActionColumn'],
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
