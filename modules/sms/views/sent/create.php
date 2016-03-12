<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\sms\models\SentSms */

$this->title = Yii::t('app', 'Create').Yii::t('app', 'Sent Sms');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sent Sms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sent-sms-create box box-danger">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
