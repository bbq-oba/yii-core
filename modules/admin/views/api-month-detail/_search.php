<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ApiMonthDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="api-month-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'idvisit') ?>

    <?= $form->field($model, 'mtime') ?>

    <?= $form->field($model, 'visitor_datatype_13') ?>

    <?= $form->field($model, 'visitor_datatype_10') ?>

    <?php // echo $form->field($model, 'visitor_datatype_11') ?>

    <?php // echo $form->field($model, 'visitor_datatype_12') ?>

    <?php // echo $form->field($model, 'updated_datatype_13') ?>

    <?php // echo $form->field($model, 'updated_datatype_10') ?>

    <?php // echo $form->field($model, 'updated_datatype_11') ?>

    <?php // echo $form->field($model, 'updated_datatype_12') ?>

    <?php // echo $form->field($model, 'visitor_username') ?>

    <?php // echo $form->field($model, 'visitor_referrer') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
