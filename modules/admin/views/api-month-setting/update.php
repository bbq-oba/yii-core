<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ApiMonthDetail */

$this->title = Yii::t('app', 'Update').Yii::t('app', 'Api Month Detail', [
    'modelClass' => 'Api Month Detail',
]) . ' ' . $model->id;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Api Month Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="api-month-detail-update box box-danger">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
