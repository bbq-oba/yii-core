<?php

use kartik\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ApiUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '永利汇表单注册用户';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="api-user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'UserName',
            'Phone',
            'ReferralCode',
            // 'Email:email',
             'createdAt',
            // 'updated_at',
            // 'ip',

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
            'before' =>false,
            'after' => false,
        ],
    ]); ?>

</div>
