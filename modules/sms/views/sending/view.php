<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\sms\models\SendingSms */

$this->title = Yii::t('app', 'View');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sending Sms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sending-sms-view box box-danger">
    <div class="box-body">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->SmsIndex], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->SmsIndex], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'SmsIndex',
//            'SmsUser',
            'PhoneNumber',
            'SmsContent',
//            'UserDefineNo',
//            'PutInType',
//            'SendLevel',
//            'SendModem',
//            'NewFlag',
//            'RM1',
//            'RM2',
//            'RM3',
        ],
    ]) ?>
    </div>
</div>
