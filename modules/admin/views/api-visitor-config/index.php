<?php

use kartik\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ApiVisitorConfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Api Visitor Configs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="api-visitor-config-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'type',
            'name',
            'url',
            'limit',
            'time',
            'from',
            // 'to',
            // 'where',
            // 'order',
            // 'range',
            // 'url:url',

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
            'before' => yii::$app->user->identity->id == 1 ? (Html::a(Html::icon('plus').Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-default'])) : '',
            'after' => false,
        ],
    ]); ?>

</div>
