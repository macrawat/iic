<?php

namespace app\modules\demomodule\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "designation".
 *
 * @property integer $id
 * @property string  $title
 * @property integer $status
 * @property string  $created_at
 * @property integer $created_by
 * @property string  $updated_at
 * @property integer $updated_by
 * @property string  $ip
 */
class Designation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ems_options_designation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'status', 'employee_category'], 'required'],
            [['employee_category', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 45],
            [['title'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Name'),
            'employee_category' => Yii::t('app', 'Employee Category'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'ip' => Yii::t('app', 'Ip'),
        ];
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoreUserAssignments()
    {
        return $this->hasMany(CoreUserAssignments::className(), ['designation' => 'id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(), //BlameableBehavior automatically fills the specified attributes with the current user ID.
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->ip = Yii::$app->request->getUserIP();
        return true;
    }
    
    
    public static function getEmployeeCategory(){
        return ['1' => 'Teaching', '2' => 'Non-Teaching'];
    }
    
    public static function resolveEmployeeCategory($id)
    {
        if (array_key_exists($id, self::getEmployeeCategory())) {
            return self::getEmployeeCategory()[$id];
        } else {
            return null;
        }
    }

    public static function getAllDesignations()
    {
        $result = ArrayHelper::map(self::find()->cache(7200)->all(), 'id', 'title');
        asort($result);
        return $result;
    }



    public static function getDesignationByType($id)
    {
        $result = ArrayHelper::map(static::find()->where(['employee_category' => $id])->all(), 'id', 'title');
        asort($result);
        return $result;
    }

    public static function getAllActiveDesignations()
    {
        $result = ArrayHelper::map(self::find()->where(['status' => 1])->all(), 'id', 'title');
        asort($result);
        return $result;
    }


    public static function getActiveDesignationByType($id)
    {
        $result = ArrayHelper::map(static::find()->where(['employee_category' => $id, 'status' => 1])->all(), 'title', 'title');
        asort($result);
        return $result;
    }
    public static function resolveDesignation($id)
    {
        $result = static::find()->cache(7200)->where(['id' => $id])->one();
        if(!empty($result)){
            return $result->title;
        }else{
            return '';
        }
    }
    
    public static function resolveDesignationByName($title)
    {
        $result = static::find()->cache(7200)->where(['title' => $title])->one();
        if(!empty($result)){
            return $result->id;
        }else{
            return null;
        }
    }

    /**
     * @param $id - ID of the Designation
     * @return mixed|string - Name of the Designation
     */
    public static function resolveById($id)
    {
        $result = static::find()->cache(7200)->where(['id' => $id])->one();
        if(!empty($result)){
            return $result->title;
        }else{
            return '';
        }
    }

    public static function getTotalCount(){
        $count = static::find()->count();
        return $count;
    }


}
