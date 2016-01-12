<?php
/**
 * @author oba.ou
 */
use \kartik\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Assignment */
/* @var $usernameField string */
/* @var $extraColumns string[] */

$this->title = Yii::t('rbac-admin', 'Assignments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assignment-index">
    <?php
    Pjax::begin([
        'enablePushState'=>false,
    ]);
    $columns =
        [
            ['class' => 'yii\grid\SerialColumn'],
            $usernameField,
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',
                'buttons'=>[
                    'view'=>function ($url, $model, $key) {
                        return Html::a(Html::icon('eye-open'), \yii\helpers\Url::to(['/rbac/assignment/view','id'=>$model->getId()]));
                    }
                ]
            ],
        ];
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]);
    Pjax::end();
    ?>

</div>
