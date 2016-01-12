<?php
/**
 * @author oba.ou
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelapp\core\models\AdminConfig*/
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="admin-config-form box-body">

    <?= $form->field($model, 'option_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'option_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'option_text')->textInput(['maxlength' => true]) ?>

</div>
<div class="box-footer">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create')    : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn
    btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>

