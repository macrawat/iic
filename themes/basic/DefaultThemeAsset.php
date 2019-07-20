<?php
namespace app\themes\basic;

use yii\web\AssetBundle;

class DefaultThemeAsset extends AssetBundle
{

    public $css = [

    ];
    public $js = [

    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->sourcePath = __DIR__ ;
    }
}
