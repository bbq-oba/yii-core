<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\SmsDbForm;

class SmsConfigController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new SmsDbForm();
        if ($model->load(\yii::$app->request->post()) && $model->save()) {
            return $this->redirect(["index"]);
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

}
