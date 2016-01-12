<?php
/**
 * @author oba.ou
 */

namespace app\core\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CoreAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/jquery.slimscroll.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\core\assets\AdminLteAsset'
    ];
    public function init(){
        if(\yii::$app->controller->module->id == 'gii'){
            //如果是GII要做一些特殊处理。
            $this->depends[] = 'yii\gii\GiiAsset';
            $this->css = [
                'css/gii.css'
            ];
        }
    }
}
