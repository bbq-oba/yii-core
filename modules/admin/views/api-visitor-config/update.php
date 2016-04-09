<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ApiVisitorConfig */

$this->title = Yii::t('app', 'Update').Yii::t('app', 'Api Visitor Config', [
    'modelClass' => 'Api Visitor Config',
]) . ' ' . $model->name;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Api Visitor Configs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="api-visitor-config-update box box-danger">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
