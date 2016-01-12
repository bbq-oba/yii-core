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
        $inputCalendarFrom = \yii::$app->request->post('inputCalendarFrom');
        $inputCalendarTo = \yii::$app->request->post('inputCalendarTo');
        $redirectUrl = \yii::$app->request->post('redirectUrl');
        Module::setCommonSession(DEFAULT_ID_SITE,$inputCalendarFrom,$inputCalendarTo);
        $this->redirect($redirectUrl);
    }
}
