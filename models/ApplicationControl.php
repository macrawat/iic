<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 21/02/19
 * Time: 2:42 PM
 */

namespace app\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "application_control".
 *
 * @property string $id
 * @property string $key
 * @property string $value
 * @property string $category
 * @property string $type
 * @property string $description
 */
class ApplicationControl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'application_control';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'value', 'app_id','type', 'category','description'], 'required'],
            [['key'], 'string', 'max' => 25],
            [['value'], 'string', 'max' => 20],
            [['type', 'category'], 'string', 'max' => 20],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'value' => 'Value',
            'type' => 'Type',
            'category' => 'Category',
            'description' => 'Description',
        ];
    }

    public static function getVariable($name)
    {
        $models = static::getAllVariable();
        if (array_key_exists($name, $models)) {
            return $models[$name];
        } else {
            return 0;
        }
    }

    public static function getVariableArray($name)
    {
        $models = static::getAllVariable();
        if (array_key_exists($name, $models) && !empty($models[$name])) {
            return unserialize($models[$name]);
        } else {
            return [];
        }
    }


    public static function getAllVariable()
    {
        return [
            'app_name' => 'Samarth Basic',
            'organisation_name' => 'Samarth',
        ];
        $models = self::find()->cache(7200)->all();
        $model = ArrayHelper::map($models, 'key', 'value');
        return $model;
    }

}