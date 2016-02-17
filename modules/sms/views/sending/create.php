<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\sms\models\SendingSms */

$this->title = "发送短信";
$this->params['breadcrumbs'][] = ['label' => "发送短信", 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sending-sms-create box box-danger">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
