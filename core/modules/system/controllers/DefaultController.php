<?php
/**
 * @author oba.ou
 */
namespace app\core\modules\system\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionInfo(){
//        phpinfo();
    }

    public function actionDemo(){
        return $this->render('demo');
    }

}
