<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StatVisit */

$this->title = Yii::t('app', 'Update').Yii::t('app', 'Stat Visit', [
    'modelClass' => 'Stat Visit',
]) . ' ' . $model->id;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Stat Visits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="stat-visit-update box box-danger">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
