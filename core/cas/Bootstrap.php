<?php
/**
 * @author oba.ou
 */
namespace app\core\cas;


use yii\base\Component;
use yii;

class Bootstrap extends Component
{
    public function init(){
        /**
         * 调用
         * 这里需要先设置一下session 的存储域名为 core.com
         * 因为 phpCas会去设置Session，他的设置Session是脱离yii的，因此并不会调用yii的session设置方法
         * 所以 默认情况下会将domain 设置为 www.xxx.com 而不是 xxx.com
         * 这样讲造成cas无法单点登陆及退出
         * 调用yii::$app->session->open() 也是可以的
         *
         */

        phpCas::init();
    }
}