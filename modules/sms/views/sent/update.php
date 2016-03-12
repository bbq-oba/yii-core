<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\sms\models\SentSms */

$this->title = Yii::t('app', 'Update').Yii::t('app', 'Sent Sms', [
    'modelClass' => 'Sent Sms',
]) . ' ' . $model->SmsIndex;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sent Sms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SmsIndex, 'url' => ['view', 'id' => $model->SmsIndex]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sent-sms-update box box-danger">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
