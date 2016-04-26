<?php
namespace app\controllers;
use app\helpers\Mobile;
use app\helpers\SmsHelper;
use app\models\ApiUser;
use app\models\SignForm;
use app\models\User;
use Yii;
use yii\captcha\CaptchaValidator;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\web\Response;

class SignController extends Controller
{

    public $layout = false;

    public function actionCaptchaCode($mobile){
        \yii::$app->response->format = Response::FORMAT_JSON;
        if(Mobile::check($mobile)){
            $return = SmsHelper::send($mobile);
        }else{
            $return = ['code'=>203, 'msg'=>'请输入正确手机号'];
        }
        return $return;
    }
    /**
     * Creates a new ApiUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ApiUser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
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
