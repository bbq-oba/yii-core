<?php
/**
 * @author oba.ou
 */
namespace app\core\gii\controllers;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DefaultController extends \yii\gii\controllers\DefaultController
{
    public $layout = '@app/core/views/layouts/main-box';
    public function actionIndex()
    {
        return $this->render('index');
    }

}
