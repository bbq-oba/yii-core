<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ApiMonthDetail */

$this->title = Yii::t('app', 'Create').Yii::t('app', 'Api Month Detail');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Api Month Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="api-month-detail-create box box-danger">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
