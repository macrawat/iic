<?php
/**
 * Created by PhpStorm.
 * User: sharadmishra
 * Date: 06/11/18
 * Time: 2:30 PM
 */

namespace app\themes\samarth\assets;

use yii\web\AssetBundle;

class SamarthThemeAsset extends AssetBundle
{

    public $css = ['css/main.css', 'css/material-design-iconic-font.css', 'css/custom.css', 'css/perfect-scrollbar.css','css/toastr.css'];
    public $js = ['js/main.js', 'js/perfect-scrollbar.js', 'js/toastr.min.js'];
    public $depends = ['yii\web\YiiAsset', 'yii\bootstrap4\BootstrapPluginAsset',];

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->sourcePath = __DIR__ . '/../src';
    }
}
