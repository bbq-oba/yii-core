<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ApiUser */

$this->title = Yii::t('app', 'Update').Yii::t('app', 'Api User', [
    'modelClass' => 'Api User',
]) . ' ' . $model->id;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Api Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="api-user-update box box-danger">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
