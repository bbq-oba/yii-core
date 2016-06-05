<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StatVisitSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stat-visit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'idvisitor') ?>

    <?= $form->field($model, 'location_ip') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'visitor_username') ?>

    <?php // echo $form->field($model, 'visitor_datatype_0') ?>

    <?php // echo $form->field($model, 'visitor_datatype_1') ?>

    <?php // echo $form->field($model, 'visitor_datatype_2') ?>

    <?php // echo $form->field($model, 'visitor_datatype_3') ?>

    <?php // echo $form->field($model, 'visitor_datatype_4') ?>

    <?php // echo $form->field($model, 'visitor_datatype_5') ?>

    <?php // echo $form->field($model, 'visitor_datatype_6') ?>

    <?php // echo $form->field($model, 'visitor_datatype_7') ?>

    <?php // echo $form->field($model, 'visitor_datatype_8') ?>

    <?php // echo $form->field($model, 'visitor_datatype_9') ?>

    <?php // echo $form->field($model, 'updated_datatype_0') ?>

    <?php // echo $form->field($model, 'updated_datatype_1') ?>

    <?php // echo $form->field($model, 'updated_datatype_2') ?>

    <?php // echo $form->field($model, 'updated_datatype_3') ?>

    <?php // echo $form->field($model, 'updated_datatype_4') ?>

    <?php // echo $form->field($model, 'updated_datatype_5') ?>

    <?php // echo $form->field($model, 'updated_datatype_6') ?>

    <?php // echo $form->field($model, 'updated_datatype_7') ?>

    <?php // echo $form->field($model, 'updated_datatype_8') ?>

    <?php // echo $form->field($model, 'updated_datatype_9') ?>

    <?php // echo $form->field($model, 'visitor_referrer') ?>

    <?php // echo $form->field($model, 'iptype') ?>

    <?php // echo $form->field($model, 'iptext') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'visitor_regtime') ?>

    <?php // echo $form->field($model, 'month_cron') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
