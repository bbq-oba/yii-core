<?php

namespace app\modules\admin\controllers;

use app\api\core\API;
use app\helpers\Page;
use app\modules\admin\models\ApiVisitorDetail;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use app\modules\admin\models\VisitsDetails;

class StatController extends \yii\web\Controller
{





    public function actionRegUserLebao(){
        $model  = new VisitsDetails();
        $model->load(\yii::$app->request->queryParams);

        $data = $model->search(1);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => $model->filter_limit,
            ],
        ]);

        return $this->render($model->render,[
            'title'=>'乐宝注册',
            'dataProvider' => $dataProvider,
            'model' =>$model
        ]);
    }


    public function actionRegUserYonglihui(){
        $model  = new VisitsDetails();
        $model->load(\yii::$app->request->queryParams);

        $data = $model->search(2);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => $model->filter_limit,
            ],
        ]);

        return $this->render($model->render,[
            'title'=>'永利汇注册',
            'dataProvider' => $dataProvider,
            'model' =>$model
        ]);
    }
    public function actionRegUserOther(){
        $model  = new VisitsDetails();
        $model->load(\yii::$app->request->queryParams);

        $data = $model->search(4);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => $model->filter_limit,
            ],
        ]);

        return $this->render($model->render,[
            'title'=>'无注册源',
            'dataProvider' => $dataProvider,
            'model' =>$model
        ]);
    }
    public function actionCommonUser(){
        $model  = new VisitsDetails();
        $model->load(\yii::$app->request->queryParams);

        $data = $model->search(3);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => $model->filter_limit,
            ],
        ]);
        return $this->render($model->render,[
            'title'=>'未注册',
            'dataProvider' => $dataProvider,
            'model' =>$model
        ]);
    }
}
