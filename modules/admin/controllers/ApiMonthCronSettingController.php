<?php

namespace app\modules\admin\controllers;

use app\helpers\MonthCron;
use Yii;
use app\models\ApiMonthCronSetting;
use app\models\ApiMonthCronSettingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\core\behaviors\TimestampBehavior;
/**
 * ApiMonthCronSettingController implements the CRUD actions for ApiMonthCronSetting model.
 */
class ApiMonthCronSettingController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            TimestampBehavior::className()
        ];
    }

    /**
     * Lists all ApiMonthCronSetting models.
     * @return mixed
     */
    public function actionIndex()
    {
        (new MonthCron())->start();
        $model = $this->findModel(MonthCron::UPDATE_ID);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }



    /**
     * Finds the ApiMonthCronSetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ApiMonthCronSetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ApiMonthCronSetting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
