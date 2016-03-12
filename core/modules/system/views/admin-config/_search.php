<?php
/**
 * @author oba.ou
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\core\models\AdminConfigSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-config-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'option_key') ?>

    <?= $form->field($model, 'option_value') ?>

    <?= $form->field($model, 'option_text') ?>

    <?= $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'creater') ?>

    <?php // echo $form->field($model, 'is_deleted') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
