<?php
/**
 * @author oba.ou
 */
use kartik\form\ActiveForm;
use \yii\helpers\Html;
?>
<div class="brand-form box-body">
    <?php $form = ActiveForm::begin(); ?>
    <?= Html::hiddenInput('act', 'query'); ?>
    <?= Html::textarea('sql', $sql, array('style' => 'height:100px;width:800px;')) ?>
    <p>执行SQL将直接操作数据库，请谨慎使用：</p>

    <div class="form-group">
        <?= Html::submitButton('执行', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<div class="box box-primary">
    <div class="box-header"><h3 class="box-title">执行结果</h3></div>
    <div class="box-body" style=" overflow: auto;">
        <?php echo $result; ?>
    </div>
</div>




