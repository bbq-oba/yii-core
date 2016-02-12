<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\sms\models\SendingSms */

$this->title = Yii::t('app', 'Create').Yii::t('app', 'Sending Sms');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sending Sms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sending-sms-create box box-danger">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
