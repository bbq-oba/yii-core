<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>推广注册</title>
    <link href="/sign/css/style.css" rel="stylesheet" type="text/css">

</head>
<body>
<div CLASS="BG">
    <div class="BG-BOX" >
        <div class="title-box">
            <img src="/sign/img/TITLE.PNG" class="TIT">
            <img src="/sign/img/slot.png" CLASS="SLOT">
        </div>
        <from>
            <div CLASS="FROM">
                <label>手机号码</label>
                <input class="INP-1" type="text">
            </div>
            <div class="FROM">
                <label class="lab1" style="padding: 0 29px 0 18px;">验证码</label>
                <input type="text" class="INP-2">
                <input type="button" value="获取验证码" class="INP-3">
            </div>
            <div CLASS="FROM">
                <label>用户帐户</label>
                <input type="text" class="INP-4">
            </div>
            <div CLASS="FROM">
                <label>用户密码</label>
                <input class="INP-5" type="text">
            </div>
            <div class="FROM">
                <a href="#"><img src="/sign/img/zhuce-btn.png" style="margin-top: 10px;"></a>
            </div>
        </from>
    </div>
</div>
</body>
</html>
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
