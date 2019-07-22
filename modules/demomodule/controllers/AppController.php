<?php
/**
 * Created by PhpStorm.
 * User: iic
 * Date: 20/07/19
 * Time: 2:02 PM
 */

namespace app\modules\demomodule\controllers;

use app\modules\demomodule\models\Dependent;
use app\modules\demomodule\models\CoreOuStructure;
use yii\web\Controller;

class AppController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDependentDropdown(){
        $model = new Dependent();
        return $this->render('dependent',['model' => $model]);
    }

    public function actionFormTemplate(){
        return $this->render('form-template');
    }
    
    public function actionModalWidget(){
        return $this->render('modal-widget');
    }


    /**
     * This function is used by ajax request
     * @param $id - ID of the OU
     * @return - select options for dropdown
     */
    public function actionListDesignations($id)
    {
        $models = CoreOuStructure::getDesignationsByOu($id);
        if (!empty($models)) {
            foreach ($models as $key => $model) {
                echo "<option value='" . $key . "'>" . $model . "</option>";
            }
        } else {
            echo "<option value='0'>Self</option>";
        }
    }

}