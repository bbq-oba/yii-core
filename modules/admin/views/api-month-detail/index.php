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

            'visitor_username',
            'viewMtime',
            'viewVisitorReferrer',
            'visitor_datatype_10',
            'visitor_datatype_11',
            'visitor_datatype_12',
            // 'visitor_datatype_12',
            // 'updated_datatype_13',
            // 'updated_datatype_10',
            // 'updated_datatype_11',
            // 'updated_datatype_12',
            // 'visitor_username',
            // 'visitor_referrer',
            // 'created_at',
            // 'updated_at',

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
            'before' => false,
            'after' => false,
        ],
    ]); ?>

</div>
