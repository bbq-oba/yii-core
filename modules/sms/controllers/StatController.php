<?php

namespace app\modules\sms\controllers;

use app\modules\sms\models\SendingSmsSearch;
use app\modules\sms\models\SentSmsSearch;
use yii\web\Controller;

class StatController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new SentSmsSearch();
        $dataProvider = $searchModel->stat(\yii::$app->request->queryParams);

        return $this->render('index',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
