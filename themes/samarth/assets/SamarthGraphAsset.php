<?php
/**
 * Created by PhpStorm.
 * User: sharadmishra
 * Date: 06/11/18
 * Time: 2:30 PM
 */

namespace app\themes\samarth\assets;

use yii\web\AssetBundle;

class SamarthGraphAsset extends AssetBundle
{

    public $css = [
        'css/c3.min.css',
    ];
    public $js = [
        'js/c3.min.js',
        'js/d3.min.js',
    ];
    public $depends = [
        'app\themes\samarth\assets\SamarthThemeAsset',
    ];
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->sourcePath = __DIR__.'/../vendors/graph';
    }
}
