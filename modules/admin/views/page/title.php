<?php

use kartik\helpers\Html;
use kartik\grid\GridView;
use \app\helpers\Column;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '页面标题';
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->timeZone = 'UTC';
?>
<div class="brand-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['value'=>'label', 'header'=>'页面标题'],
            ['value'=>'nb_visits', 'header'=>'唯一页面浏览量'],
            ['value'=>'bounce_rate', 'header'=>'跳出率'],
            [
                'value'=>'avg_time_on_page',
                'header'=>'平均停留时间',
                'format'=>['date','H:i:s']
            ],
            ['value'=>'exit_rate', 'header'=>'退出率'],
            [
                'value'=>function($data){
                    return yii::$app->formatter->asDecimal($data['avg_time_generation'],2).'秒';
                },
                'header'=>'平均生成时间',
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
