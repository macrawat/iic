<?php

namespace app\modules\demomodule\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use app\modules\master\models\EmsOptionsDesignation;
/**
 * This is the model class for table "core_ou_structure".
 *
 * @property string $id
 * @property string $ou_id
 * @property string $designation_id
 * @property string $parent_id
 * @property int $is_parent
 * @property int $depth
 * @property string $path
 * @property string $created_at
 * @property string $updated_at
 * @property string $created_by
 * @property string $updated_by
 * @property string $ip
 */
class CoreOuStructure extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'core_ou_structure';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ou_id', 'designation_id', 'parent_id'], 'required'],
            [['ou_id', 'designation_id', 'parent_id'], 'unique', 'targetAttribute' => ['ou_id', 'designation_id', 'parent_id'],
                'message' => Yii::t('app','This entry is already saved')],
            [['ou_id', 'designation_id', 'parent_id', 'is_parent', 'depth', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['path'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 40],
            [['designation_id'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app','ID'),
            'ou_id' => Yii::t('app','Organizational Unit'),
            'designation_id' => Yii::t('app','Designation'),
            'parent_id' => Yii::t('app','Reporting Designation'),
            'is_parent' => Yii::t('app','Is Parent ?'),
            'depth' => Yii::t('app','Depth'),
            'path' => Yii::t('app','Path'),
            'created_at' => Yii::t('app','Created At'),
            'updated_at' => Yii::t('app','Updated At'),
            'created_by' => Yii::t('app','Created By'),
            'updated_by' => Yii::t('app','Updated By'),
            'ip' => Yii::t('app','IP'),
        ];
    }
    /**
     * {@inheritdoc}
     */

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
     * {@inheritdoc}
     *
     * @param bool $insert
     * @return bool
     */

    public function beforeSave($insert)
    {
        date_default_timezone_set("Asia/Kolkata");
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->ip = Yii::$app->request->getUserIP();

        $this->depth = static::getParentDepth($this->parent_id, $this->ou_id) + 1;
//        $this->path = static::getParentPath($this->parent_id, $this->ou_id);


        return true;
    }

    /**
     * @param $ou : ID of the Organisational Unit
     * @return array|null : Array of Designations , Key-Value Pair
     */
    public static function getParentDesignations($ou)
    {

        $parent_ou_id = AdministrativeUnit::getParentId($ou);
        $model = self::find()->cache(7200)
            ->where(['IN','ou_id',[$ou,$parent_ou_id]])
            ->orderBy(['ou_id' => SORT_ASC])
            ->all();
        if (!empty($model)) {
            return ArrayHelper::map($model, 'id',
                function ($data) {
                    return Designation::resolveById($data->designation_id)." (".
                        AdministrativeUnit::resolveById($data->ou_id).")";
                }
            );
        } else {
            return [];
        }
    }
    
    /**
     * @param $ou : ID of the Organisational Unit
     * @return array|null : Array of Designations , Key-Value Pair
     */
    public static function getDesignationsByOunType($ou,$type)
    {
        $designationByType = array_flip(Designation::getDesignationByType($type));         
        $model = self::find()->cache(7200)->where(['ou_id' => $ou])->andWhere(['designation_id' => $designationByType])->all();
        if (!empty($model)) {
            return ArrayHelper::map($model, 'designation_id',
                function ($data) {
                    return Designation::resolveDesignation($data->designation_id);
                }
            );
        } else {
            return NULL;
        }
    }

    /**
     * This function returns the list of departments for which Structure already exist in the system
     * @return array|null
     */
    public static function getExistingOu()
    {
        $model = self::find()->select('ou_id')->cache(7200)->distinct()->all();
        if (!empty($model)) {
            return ArrayHelper::map($model, 'ou_id',
                function ($data) {
                    return AdministrativeUnit::resolveById($data->ou_id);
                }
            );
        } else {
            return NULL;
        }
    }

    /**
     * This function returns the list of departments for which Structure does not exist in the system
     * @return array|null
     */
    public static function getNonExistingOu()
    {
        $model = self::find()->select('ou_id')->cache(7200)->asArray()->all();
        $arr = ArrayHelper::toArray($model, 'ou_id');
        $farr = [];
        foreach ($arr as $ar){
            $farr = $ar;
        }
        if (!empty($model)) {
            $ous = AdministrativeUnit::find()->where(['NOT IN', 'id', $farr])->all();
            return ArrayHelper::map($ous, 'id', 'name');
        } else {
            return NULL;
        }
    }

    /**
     * @param $parent_id
     * @return string
     */
    public static function getParentPath($parent_id, $ou_id)
    {
        $model = self::find()->where(['id' => $parent_id, 'ou_id' => $ou_id])->one();
        if (!empty($model)) {
            return $model->path;
        } else {
            return '';
        }
    }

    /**
     * @param $parent_id
     * @return int
     */
    public static function getParentDepth($parent_id, $ou_id)
    {
        $model = self::find()->where(['id' => $parent_id, 'ou_id' => $ou_id])->one();
        if (!empty($model)) {
            return $model->depth;
        } else {
            return 0;
        }
    }

     /**
     * This function return the designation of the structure id
     * @param $id - ID of the OU structure
     * @return int|mixed|string
     */

    public static function getMyDesignationName($id)
    {
        $model = self::find()->where(['id' => $id])->one();
        if (!empty($model)) {
            return Designation::resolveDesignation($model->designation_id);
        } else {
            return 'Self';
        }
    }
    
    /**
     *
     */
    public static function getDesignationsByOu($ou)
    {
        $model = self::find()->cache(7200)
            ->where(['IN', 'ou_id', [$ou]])
            ->all();
        if (!empty($model)) {
            return ArrayHelper::map($model, 'designation_id',
                function ($data) {
                    return Designation::resolveById($data->designation_id) . " (" .
                        AdministrativeUnit::resolveById($data->ou_id) . ")";
                }
            );
        } else {
            return NULL;
        }
    }
    
    public static function getParentDesignationByEmployeeDesignationOU($ou,$designation){
        $model= static::find()->select(['parent_id'])->where(['ou_id' => $ou,'designation_id'=>$designation])->one();        
        if(!empty($model)){
            $parentDesignation = static::find()->select(['designation_id'])->where(['id' =>$model->parent_id])->one();
            if(!empty($parentDesignation)){
                return $parentDesignation->designation_id;
            }else{
                return false;
            }
        }
        return false;
        
    }

}
