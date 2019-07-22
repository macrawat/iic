<?php

namespace app\modules\demomodule\models;

use Yii;

/**
 * This is the model class for table "demo".
 *
 * @property string $id
 * @property string $name User Name
 * @property string $middle_name
 * @property string $mobile Mobile
 * @property string $email
 * @property int $city
 * @property string $other_city Other City
 * @property int $status Active/Inactive
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property string $ip
 */
class Demo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'demo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'mobile', 'email', 'city', 'status'], 'required'],
            [['mobile', 'city', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],

            [['mobile'], 'match', 'pattern' => '/^[6789]\d{9}$/'],
            [['email'],'email'],
            [['name', 'middle_name', 'email', 'other_city'], 'string', 'max' => 128],

            [['other_city'], 'required', 'when' => function ($model) {
                return $model->city == 2;
            }, 'whenClient' => "function (attribute, value) {
                       return $('#demo-city').val() == 2;
                   }", 'message' => '{attribute} cannot be blank'],

            [['ip'], 'string', 'max' => 20],
            [['mobile', 'email'], 'unique', 'targetAttribute' => ['mobile', 'email']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'mobile' => Yii::t('app', 'Mobile'),
            'email' => Yii::t('app', 'Email'),
            'city' => Yii::t('app', 'City'),
            'other_city' => Yii::t('app', 'Other City'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'ip' => Yii::t('app', 'Ip'),
        ];
    }

    public static function getCity(){
        return ['1'=>'Delhi','2'=>'Other'];
    }

    public static function resolveCity($id){
        return self::getCity()[$id];
    }



}
