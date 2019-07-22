<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 22/07/19
 * Time: 12:03 AM
 */

namespace app\modules\demomodule\models;


use Yii;
use yii\base\Model;

class Dependent extends Model
{
    public $department,$designation;

    public function rules() {
        return [
            [['department','designation'], 'integer'],

        ];
    }

    public function attributeLabels() {
        return [
            'department' => 'Department',
            'designation' => 'Designation',

        ];
    }
}