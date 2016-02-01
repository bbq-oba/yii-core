<?php

use kartik\helpers\Html;
use kartik\grid\GridView;
use \app\helpers\Column;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '普通访客';
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->timeZone = 'UTC';
$type = \yii::$app->request->get("type");

//$panel = '<div class="btn-group" role="group">'.
//    Html::a("普通访客", ['index'], ['class' => 'btn btn-default'.($type != 'regUser' ? ' active': '')]).
//    Html::a("注册用户", ['index','type'=>'regUser'], ['class' => 'btn btn-default'.($type == 'regUser' ? ' active': '')]).
//'</div>';
//&filter_offset=40&filter_limit=20

$panel = "";

?>


<div class="brand-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => \app\modules\admin\helpers\StatColumns::getCommonUserColumns(),
        'pjax' => true,
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'export' => false,
        'condensed' => true,
        'hover' => true,
        'panel' => [
            'heading' => '',
            'type' => GridView::TYPE_SUCCESS,
            'before' => $panel,
            'after' => \app\helpers\Page::preNext(),
        ],
    ]); ?>

</div>
