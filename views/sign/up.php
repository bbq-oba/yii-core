<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelapp\modules\admin\models\CmsArticle */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="cms-article-form box-body">
    <?= $form->field($model, 'UserName')->textInput() ?>
    <?= $form->field($model, 'Password')->textInput() ?>
    <?= $form->field($model, 'TrueName')->textInput() ?>
    <?= $form->field($model, 'Phone')->textInput() ?>
    <?= $form->field($model, 'Email')->textInput() ?>
    <?= $form->field($model, 'ReferralCode')->textInput() ?>
</div>
<div class="box-footer">
    <?= Html::submitButton('登录', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>

