<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ApiMonthCronSetting */

$this->title = Yii::t('app', 'Update').Yii::t('app', 'Api Month Cron Setting', [
    'modelClass' => 'Api Month Cron Setting',
]) . ' ' . $model->id;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Api Month Cron Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="api-month-cron-setting-update box box-danger">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
