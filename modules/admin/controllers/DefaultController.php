<?php

namespace app\modules\admin\controllers;

use app\modules\admin\Module;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionDate(){

        $date = \yii::$app->request->post('date');
        list ($from,$to) = explode(',',$date);
        $redirectUrl = \yii::$app->request->post('redirectUrl');
        Module::setCommonSession(DEFAULT_ID_SITE,$from,$to);
        $this->redirect($redirectUrl);
    }
}
