<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ApiUser */

$this->title = '注册';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .api-user-create {
        width: 300px;
        margin: 30px auto 0 auto;
    }
</style>
<div class="api-user-create box box-danger">
    <?php $form = ActiveForm::begin(); ?>
    <div class="api-user-form box-body">
        <?= $form->field($model, 'Phone')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'smsCode')->widget(\app\core\widgets\VerifySms::className(), [
            'template' => '<div class="row"><div class="col-lg-6">{input}</div><div class="col-lg-6">{button}</div></div>',
        ]) ?>
        <?= $form->field($model, 'UserName')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'Password')->passwordInput(['maxlength' => true]) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn
    btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
