<?php
namespace app\controllers;
use app\models\SignForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
class SignController extends Controller
{

    public $layout = false;


    public function actionUp(){
        $model = new SignForm();

        if ($model->load(Yii::$app->request->post()) && $return = $model->signUp()) {
            print_r($_POST);
            print_r($return);
//            return $this->redirect(['view', 'id' => $model->aid]);
        } else {
            return $this->render('up', [
                'model' => $model,
            ]);
        }
    }
    public function actionIn(){
        $model = new SignForm();

        return $this->render('in',[
            'model'=>$model
        ]);
    }



}
