<?php
/**
 * @author oba.ou
 */
use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = 'Redis Tool';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="box box-danger">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-header"></div>
    <div class="box-body">
        <div class="box-body">
            <?= $form->field($model, 'commands')->radioButtonGroup(array_combine(yii::$app->redis->redisCommands, yii::$app->redis->redisCommands)) ?>
            <?= $form->field($model, 'params')->textarea([
                'rows' => '10',
            ]) ?>
            <div class="form-group">
                <label class="control-label">执行结果</label>
                <?php var_dump($result); ?>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('执行', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
