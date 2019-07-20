<?php
/**
 * Created by PhpStorm.
 * User: iic
 * Date: 20/07/19
 * Time: 2:01 PM
 */

namespace app\modules\demomodule;

/**
 * cas module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\demomodule\controllers';
    public $defaultRoute = 'app';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
