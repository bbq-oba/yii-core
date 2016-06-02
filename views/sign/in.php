
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
    .regBox{ width: 300px; margin-top: 20px; padding: 20px;
        margin-left: 370px; background: #ffffff;-moz-border-radius: 15px;      /* Gecko browsers */
        -webkit-border-radius: 15px;   /* Webkit browsers */
        border-radius:15px;}

    h1{ font-size: 20px; color:#000;}
    #regSuccess li{ list-style: none; height: 40px; float: none;
        line-height:40px; font-size: 18px; text-align: left;;
        color: #000;;}
</style>

<link href="/sign/css/style.css" rel="stylesheet" type="text/css">

<div CLASS="BG">
    <div class="BG-BOX" >
        <div class="title-box">
            <img src="/sign/img/tit.png" class="TIT">
            <img src="/sign/img/slot.png" CLASS="SLOT">
        </div>
        <div class="regBox">
            <h1>注册成功,请牢记！</h1>
            <ol id="regSuccess">
                <li>用户名：<?php echo $username;?></li>
                <li>密　码：<?php echo $password;?></li>
                <li>手机号：<?php echo $mobile;?></li>
            </ol>
        </div>
    </div>
</div>


