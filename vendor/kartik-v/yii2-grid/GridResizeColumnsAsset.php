<?php

/**
 * @package   yii2-grid
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2015
 * @version   3.0.9
 */

namespace kartik\grid;

use \kartik\base\AssetBundle;

/**
 * Asset bundle for GridView Widget (for resizing columns)
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class GridResizeColumnsAsset extends AssetBundle
{
    public $depends = [
        'kartik\grid\GridViewAsset'
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('js', ['js/jquery.resizableColumns']);
        $this->setupAssets('css', ['css/jquery.resizableColumns']);
        parent::init();
    }
}
