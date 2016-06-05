<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\StatVisit */

$this->title = Yii::t('app', 'View');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Stat Visits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stat-visit-view box box-danger">
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
            'idvisitor',
            'location_ip',
            'status',
            'visitor_username',
            'visitor_datatype_0',
            'visitor_datatype_1',
            'visitor_datatype_2',
            'visitor_datatype_3',
            'visitor_datatype_4',
            'visitor_datatype_5',
            'visitor_datatype_6',
            'visitor_datatype_7',
            'visitor_datatype_8',
            'visitor_datatype_9',
            'updated_datatype_0',
            'updated_datatype_1',
            'updated_datatype_2',
            'updated_datatype_3',
            'updated_datatype_4',
            'updated_datatype_5',
            'updated_datatype_6',
            'updated_datatype_7',
            'updated_datatype_8',
            'updated_datatype_9',
            'visitor_referrer',
            'iptype',
            'iptext',
            'updated_at',
            'created_at',
            'visitor_regtime',
            'month_cron',
        ],
    ]) ?>
    </div>
</div>
