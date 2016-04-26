<?php
namespace app\controllers;
use app\helpers\Mobile;
use app\helpers\SignLogic;
use app\helpers\SmsHelper;
use app\models\ApiUser;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class SignController extends Controller
{

    public $layout = '@app/views/sign/layouts/sign';

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
    public function actionUp()
    {
        $this->layout = '@app/views/sign/layouts/sign';
        $model = new ApiUser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $render = (new SignLogic())->signIn($model->UserName,$model->Password);
            return $this->render('in',[
                'render'=>$render
            ]);
        } else {
            return $this->render('up', [
                'model' => $model,
            ]);
        }
    }
}
