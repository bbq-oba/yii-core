<?php

namespace app\modules\admin\controllers;

use app\api\core\API;
use app\helpers\ArrayDataProvider;
use app\helpers\Page;
use app\helpers\RegUser;
use app\modules\admin\models\ApiVisitorDetail;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Response;
use app\modules\admin\models\VisitsDetails;

class StatController extends \yii\web\Controller
{


    public function actionRegUserLebao()
    {
        $model = new \app\models\VisitForm();
        $model->load(\yii::$app->request->queryParams);
        $model->segment[] = 'userId!=';
        $model->initSearch();
        $model->segment[] = 'customVariableValue2==1';
        $count = $model->search('VisitsSummary.getVisits');
        $model->initPage();
        $data = $model->search('Live.getLastVisitsDetails');
        if (isset($data['result']) && $data['result'] == 'error') {
            \yii::$app->session->setFlash('error', $data['message']);
            return $this->redirect('common-user');
        }
        $data = $model->getDb($data);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'totalCount' => isset($count['value']) ? $count['value'] : 0,
            'pagination' => [
                'pageSize' => $model->pageSize,
            ],
        ]);
        return $this->render('reg-user', [
            'title' => '乐宝用户',
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }


    public function actionRegUserYonglihui()
    {
        $model = new \app\models\VisitForm();
        $model->load(\yii::$app->request->queryParams);
        $model->segment[] = 'userId!=';
        $model->initSearch();
        $model->segment[] = 'customVariableValue2==2';
        $count = $model->search('VisitsSummary.getVisits');
        $model->initPage();
        $data = $model->search('Live.getLastVisitsDetails');
        if (isset($data['result']) && $data['result'] == 'error') {
            \yii::$app->session->setFlash('error', $data['message']);
            return $this->redirect('common-user');
        }
        $data = $model->getDb($data);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'totalCount' => isset($count['value']) ? $count['value'] : 0,
            'pagination' => [
                'pageSize' => $model->pageSize,
            ],
        ]);
        return $this->render('reg-user', [
            'title' => '永利汇用户',
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
//    public function actionRegUserOther(){
//        $model  = new VisitsDetails();
//        $model->load(\yii::$app->request->queryParams);
//
//        $data = $model->search(4);
//        $dataProvider = new ArrayDataProvider([
//            'allModels' => $data,
//            'pagination' => [
//                'pageSize' => $model->filter_limit,
//            ],
//        ]);
//
//        return $this->render($model->render,[
//            'title'=>'无注册源',
//            'dataProvider' => $dataProvider,
//            'model' =>$model
//        ]);
//    }


//    public function actionCommonUser(){
//        $model  = new VisitsDetails();
//        $model->load(\yii::$app->request->queryParams);
//
//        $data = $model->search(3);
//
//        $dataProvider = new ArrayDataProvider([
//            'allModels' => $data,
//            'totalCount'=>1000,
//            'pagination' => [
//                'pageSize' => \yii::$app->request->get('filter_limit',50),
//            ],
//        ]);
//        return $this->render($model->render,[
//            'title'=>'未注册',
//            'dataProvider' => $dataProvider,
//            'model' =>$model
//        ]);
//    }

    public function actionCommonUser()
    {
        $model = new \app\models\VisitForm();
        $model->load(\yii::$app->request->queryParams);
        $model->initSearch();
        $count = $model->search('VisitsSummary.getVisits');
        $model->initPage();
        $data = $model->search('Live.getLastVisitsDetails');

        if (isset($data['result']) && $data['result'] == 'error') {
            \yii::$app->session->setFlash('error', $data['message']);
            return $this->redirect('common-user');
        }


        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'totalCount' => isset($count['value']) ? $count['value'] : 0,
            'pagination' => [
                'pageSize' => $model->pageSize,
            ],
        ]);
        return $this->render('common-user', [
            'title' => '未注册',
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

}
