<?php

use kartik\helpers\Html;
use kartik\grid\GridView;
use \app\helpers\Column;



/* @var $this yii\web\View */
/* @var $searchModel app\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
<<<<<<< HEAD
//Yii::$app->timeZone = 'UTC';
$type = \yii::$app->request->get("type");

$panel = '<div class="btn-group" role="group">'.
    Html::a("更新用户API数据", ['update-reg-user','filter_limit'=>\yii::$app->request->get('filter_limit'),'filter_offset'=>\yii::$app->request->get('filter_offset')]).
'</div>';
//&filter_offset=40&filter_limit=20
=======
>>>>>>> 558994698949798980a1cd203dd7f3ff66170cd2

?>


<div class="brand-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => \app\modules\admin\helpers\StatColumns::getRegUserColumns(),
        'pjax' => true,
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'export' => false,
        'condensed' => true,
        'hover' => true,
        'panel' => [
            'heading' => '',
            'type' => GridView::TYPE_SUCCESS,
            'before' => $this->render('_search',[
                'model'=>$model
            ]),
            'after' => \app\helpers\Page::preNext(),
        ],
    ]); ?>

</div>
