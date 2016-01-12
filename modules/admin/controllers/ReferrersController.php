<?php

namespace app\modules\admin\controllers;

use app\api\core\API;
use yii\data\ArrayDataProvider;

class ReferrersController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetReferrerType(){


        $data = API::run('Referrers.getReferrerType');
        $dataProvider = new ArrayDataProvider(['allModels' => $data]);
        return $this->render('get-referrer-type',[
            'dataProvider' => $dataProvider
        ]);
    }
}
