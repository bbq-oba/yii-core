<?php
use yii\helpers\Html;
use \kartik\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\ApiUser */

$this->title = '注册';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .api-user-create {
        width: 350px;
        margin: 0px auto 0 auto;
    }
    input:-webkit-autofill {
        background-color: #FAFFBD;
        background-image: none;
        color: #000;
    }
    .api-user-form .has-success .control-label{ color: #ffffff;}
    .api-user-form .has-error label,.has-error .help-block{ color: #ffffff;}
    .control-label { font-size: 18px; color:#ffffff;}
    .regBtn{ width: 246px; margin: 0; padding: 0; border:0; background: none; text-indent:  -9999px;
        font-size:0;
        height:66px; background-image:url("/sign/img/zhuce-btn.png");}
</style>

<link href="/sign/css/style.css" rel="stylesheet" type="text/css">

<div CLASS="BG">
    <div class="BG-BOX" >
        <div class="title-box">
            <img src="/sign/img/tit.png" class="TIT">
            <img src="/sign/img/slot.png" CLASS="SLOT">
        </div>
        <div class="api-user-create box box-danger">
            <?php $form = \kartik\form\ActiveForm::begin(
                [
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'formConfig' => ['labelSpan' =>4, 'deviceSize' => ActiveForm::SIZE_SMALL]
                ]
            ); ?>
            <div class="api-user-form box-body">
                <?= $form->field($model, 'Phone')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'smsCode')->widget(\app\core\widgets\VerifySms::className(), [
                    'template' => '<div class="row"><div class="col-lg-6">{input}</div><div class="col-lg-6">{button}</div></div>',
                ]) ?>

                <?= $form->field($model, 'UserName')->textInput(['maxlength' => true,'autocomplete'=>'off']) ?>

                <?= $form->field($model, 'Password')->passwordInput(['maxlength' => true]) ?>

            </div>
            <div class="box-footer" style="margin-top: 20px;">
                <?= Html::submitButton('立即注册', ['class' => 'regBtn']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>


