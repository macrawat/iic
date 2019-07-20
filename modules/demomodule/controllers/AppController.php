<?php
/**
 * Created by PhpStorm.
 * User: iic
 * Date: 20/07/19
 * Time: 2:02 PM
 */

namespace app\modules\demomodule\controllers;

use yii\web\Controller;

class AppController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}