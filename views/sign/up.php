<?php
use yii\helpers\Html;
use \kartik\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\ApiUser */

$this->title = '注册';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .api-user-create {
        width: 350px;
        margin: 0px auto 0 auto;
    }
    input:-webkit-autofill {
        background-color: #FAFFBD;
        background-image: none;
        color: #000;
    }
    .api-user-form .has-success .control-label{ color: #ffffff;}
    .api-user-form .has-error label,.has-error .help-block{ color: #ffffff;}
    .control-label { font-size: 18px; color:#ffffff;}
    .regBtn{ width: 246px; margin: 0; padding: 0; border:0; background: none; text-indent:  -9999px;
        font-size:0;
        height:66px; background-image:url("/sign/img/zhuce-btn.png");}
</style>

<link href="/sign/css/style.css" rel="stylesheet" type="text/css">

<?php
$url = \yii\helpers\Url::to(['sign/check']);
$getCodeUrl = \yii\helpers\Url::to(['sign/captcha-code']);
$js = <<<JS
    var demo = $(".api-user-create").Validform({
            showAllError:true,
            tiptype:function(msg,o,cssctl){
                //msg：提示信息;
                //o:{obj:*,type:*,curform:*}, obj指向的是当前验证的表单元素（或表单对象），type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态, curform为当前form对象;
                //cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
                if(!o.obj.is("form")){//验证表单元素时o.obj为该表单元素，全部验证通过提交表单时o.obj为该表单对象;
                    var objtip=o.obj.parent().next().next();
                    cssctl(objtip,o.type);
                    objtip.text(msg);
                }
            },
            datatype:{
                "smsCode":function(gets,obj,curform,regxp){
                    if(beforeCheckSms()){
                        var reg1=/\d{5}/;
                        if(reg1.test(gets)){
                            var flag = false;
                                $.ajax({
                                    async:false,
                                    type: 'post',
                                    url: 'check-sms-code',
                                    dataType:"json",
                                    data:{
                                        mobile:$('#apiuser-phone').val(),
                                        code:$('#apiuser-smscode').val()
                                    },
                                    success: function(data, textStatus){
                                        flag = (data.code == 1)
                                    }
                                });
                            return flag;
                        }
                        return false;
                    }
                    return false;
                }
	        }
    });

    function beforeCheckSms(){
        var flag = false;
        if(demo.check(false,$('#apiuser-username,#apiuser-password,#apiuser-phone'))){
             flag = $('#check .Validform_wrong').length == 0
        }
        return flag;
    }
    var verifyFlag = true;

    var timer;
    var time = initTime =  120;
    function vStart(){
       jQuery('#apiuser-smscode-button').attr('disabled','disabled').html('<span id=\"verifyTime\">'+time+'</span>秒后重新获取');
       timer = window.setTimeout(function(){
            if(!time){
                window.clearTimeout(timer);
                jQuery('#apiuser-smscode-button').attr('disabled',false).html('点击获取验证码');
                time = initTime;
                verifyFlag = true;
            }else{
                time--;
                $('#verifyTime').html(time);
                vStart();
            }
       },1000);
    }

    jQuery('#apiuser-smscode-button').click(function(){
        if(beforeCheckSms()){
            var mobile = $('#apiuser-phone').val();
            if(verifyFlag){
                $.ajax({
                   type: 'get',
                    url: '$getCodeUrl',
                    data:{
                        mobile:mobile
                    },
                    success: function(data, textStatus){
                        if(data.code != 200){
                            verifyFlag = true;
                            alert(data.msg);
                        }else{
                            vStart();
                        }
                    }
                });
            }
        }
    });

JS;
$this->registerJs($js,\yii\web\View::POS_READY);
?>

<script>

</script>

<div CLASS="BG">
    <div class="BG-BOX" >
        <div class="title-box">
            <img src="/sign/img/tit.png" class="TIT">
            <img src="/sign/img/slot.png" CLASS="SLOT">
        </div>
        <div class="api-user-create box box-danger">
            <?php $form = \kartik\form\ActiveForm::begin(
                [
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'enableClientValidation'=>false,
//                    'enableAjaxValidation' => 'true',
                    'formConfig' => ['labelSpan' =>4, 'deviceSize' => ActiveForm::SIZE_SMALL]
                ]
            ); ?>
            <div class="api-user-form box-body">
                <div id="check">
                <?= $form->field($model, 'UserName')->textInput(['maxlength' => true,'autocomplete'=>'off','datatype'=>'s3-12','ajaxurl'=>'check','nullmsg'=>"请输入用户名 ！"]) ?>
                <?= $form->field($model, 'Password')->passwordInput(['maxlength' => true,'datatype'=>'*','nullmsg'=>"请输入密码 ！"]) ?>
                <?= $form->field($model, 'Phone')->textInput(['maxlength' => true,'datatype'=>'n11-11','ajaxurl'=>'check','nullmsg'=>"请输入手机号 ！",'errormsg'=>'手机号格式错误']) ?>
                </div>
                <?= $form->field($model, 'smsCode')->widget(\app\core\widgets\VerifySms::className(), [
                    'template' => '<div class="row"><div class="col-lg-6">{input}</div><div class="col-lg-6">{button}</div><div style="clear: both; padding-left:15px;"></div></div>',
                    'options'=>[
                        'class' => 'form-control',
                        'datatype'=>'smsCode','nullmsg'=>"请输入验证码 ！",'errormsg'=>'验证码错误',
                    ]
                ]) ?>
            </div>
            <div class="box-footer" style="margin-top: 20px;">
                <?= Html::submitButton('立即注册', ['class' => 'regBtn','name'=>'reg']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>


