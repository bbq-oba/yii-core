<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ApiMonthDetail */

$this->title = Yii::t('app', 'View');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Api Month Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="api-month-detail-view box box-danger">
    <div class="box-body">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'idvisit',
            'mtime',
            'visitor_datatype_13',
            'visitor_datatype_10',
            'visitor_datatype_11',
            'visitor_datatype_12',
            'updated_datatype_13',
            'updated_datatype_10',
            'updated_datatype_11',
            'updated_datatype_12',
            'visitor_username',
            'visitor_referrer',
            'created_at',
            'updated_at',
        ],
    ]) ?>
    </div>
</div>
