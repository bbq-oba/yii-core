<?php
namespace app\controllers;

use app\helpers\Mobile;
use app\helpers\SignLogic;
use app\helpers\SmsHelper;
use app\models\ApiUser;
use kartik\form\ActiveForm;
use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;

class SignController extends Controller
{

    public $layout = '@app/views/sign/layouts/sign';

    public function actionCheck(){
        $name = \yii::$app->request->post('name');
        $value = \yii::$app->request->post('param');

        \yii::$app->response->format = Response::FORMAT_JSON;

        if($name == 'ApiUser[UserName]'){
            $return = (new SignLogic())->checkUsername($value);
            if($return['data'] == false){
                return ["info"=>"通过信息验证！","status"=>"y"];
            }else{
                return ["info"=>"该账号已经注册","status"=>"n"];
            }
        }
        if($name == 'ApiUser[Phone]'){
            if(!Mobile::check($value)){
                return ["info"=>"手机号格式有误","status"=>"n"];
            }
            $return = (new SignLogic())->checkPhone($value);
            if($return['data'] == false){
                return ["info"=>"通过信息验证！","status"=>"y"];
            }else{
                return ["info"=>"该手机号已经注册","status"=>"n"];
            }
        }
    }
    public function actionCheckUsername($username){
        \yii::$app->response->format = Response::FORMAT_JSON;
        return (new SignLogic())->checkUsername($username);
    }
    public function actionCheckPhone($phone){
        \yii::$app->response->format = Response::FORMAT_JSON;
        return (new SignLogic())->checkPhone($phone);
    }

    public function actionCheckSmsCode(){

        $mobile = \yii::$app->request->post('mobile');
        $code = \yii::$app->request->post('code');

        \yii::$app->response->format = Response::FORMAT_JSON;

        $model = new ApiUser();

        $model->Phone = $mobile;
        $model->smsCode = $code;
        return ["code"=>$model->validateSmsCode('','') == true  ? 1 : 0];
    }



    public function actionCaptchaCode($mobile)
    {
        \yii::$app->response->format = Response::FORMAT_JSON;
        if (Mobile::check($mobile)) {

            $model = new ApiUser;
            $model = $model->find()->where([
                'Phone'=>$mobile
            ])->one();
            if($model){
                return ['code' => 203, 'msg' => '手机号已经注册'];
            }
            $return = SmsHelper::send($mobile);
            if($return['code'] !=200){
                $return['msg'] = '请';
            }
        } else {
            $return = ['code' => 203, 'msg' => '请输入正确手机号'];
        }
        return $return;
    }

    /**
     * Creates a new ApiUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUp()
    {
        $this->layout = '@app/views/sign/layouts/sign';
        $model = new ApiUser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            SmsHelper::sendRegSuccess($model->Phone,$model->UserName,$model->Password);
            return $this->render('in', [
                'username' => $model->UserName,
                'password' => $model->Password,
                'mobile'=>$model->Phone
            ]);
        } else {
            return $this->render('up', [
                'model' => $model,
            ]);
        }
    }

    public function actionTest($u = 'oooo1111', $p = '123123z')
    {
            return $this->render('in', [
                'password' => $p,
                'username' => $u,
                'mobile'=>123123123
            ]);
    }

}
