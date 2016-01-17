<?php

namespace app\modules\admin\controllers;

use app\api\core\API;
use yii\data\ArrayDataProvider;
use yii\web\Response;

class VisitorController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    //页面标题
    public function actionLog(){
        $data = API::run('Live.getLastVisitsDetails',[
            'flat' => true
        ]);
        $dataProvider = new ArrayDataProvider(['allModels' => $data]);
        return $this->render('log',[
            'dataProvider' => $dataProvider
        ]);
    }
}
