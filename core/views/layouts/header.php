<?php
/**
 * @author oba.ou
 */
use yii\helpers\Html;
use \kartik\widgets\ActiveForm;
/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">TJ</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <?php $form = ActiveForm::begin([
            'type'=>ActiveForm::TYPE_INLINE,
            'action'=>\yii\helpers\Url::to(['/admin/default/date']),
            'options' =>
                [
                    'enctype' => 'multipart/form-data',
                    'style' =>'float:left;margin-top:7px;'
                ]
        ]);

        $params = \app\modules\admin\Module::getCommonSession();
        echo \kartik\daterange\DateRangePicker::widget([
            'attribute'=>"date",
            'name'=>'date',
            'value'=>$params['from'].','.$params['to'],
            'convertFormat'=>true,
            'pluginOptions'=>[
//                'timePicker'=>true,
//                'timePickerIncrement'=>15,
//                'timePicker24Hour'=>true,
                'locale'=>[
                    'separator'=>',',
                    'format'=>'Y-m-d'
                ],
                'opens'=>'right'
            ],
        ]);
        echo Html::hiddenInput('redirectUrl',yii::$app->request->getAbsoluteUrl());

        ?>
        <?= Html::submitButton('ok', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>


        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?= \kartik\helpers\Html::icon('user')?><span class="hidden-xs"><?php echo yii::$app->user->identity->username?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="/logo.jpg" class="img-circle"/>
                            <p>
                                <?php echo yii::$app->user->identity->username?> - <?php echo yii::$app->user->identity->username?>
                                <small>id:<?php echo yii::$app->user->identity->id?></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
