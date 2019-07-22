<?php

namespace app\modules\demomodule\models;

use app\models\ApplicationControl;
use moonland\phpexcel\Excel;
use Yii;
use yii\base\UserException;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "core_administrative_unit".
 *
 * @property string $id
 * @property int $type Library,Faculty,Branch
 * @property int $parent_id
 * @property int $is_parent
 * @property int $depth
 * @property string $path
 * @property string $name
 * @property string $name_in_hindi
 * @property string $name_in_other_language
 * @property string $code
 * @property int $order
 * @property int $faculty_name
 * @property string $profile
 * @property string $official_email
 * @property int $official_login_account_mapped
 * @property string $address
 * @property string $telephone_number
 * @property string $fax
 * @property string $extension_number
 * @property string $website
 * @property string $facebook_link
 * @property string $linkedin_link
 * @property string $twitter_link
 * @property string $logo
 * @property string $geo_coordinates
 * @property int $head_of_department
 * @property int $status
 * @property int $verified
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property string $ip
 */
class AdministrativeUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%core_administrative_unit}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'parent_id', 'name', 'name_in_hindi', 'profile', 'official_email', 'address'], 'required'],
            [['type', 'parent_id', 'is_parent', 'depth', 'order', 'official_login_account_mapped', 'current_head', 'status',
                'verified', 'created_at', 'updated_at', 'created_by', 'updated_by', 'campus_id'], 'integer'],
            [['profile', 'address'], 'string'],
            [['path'], 'string', 'max' => 255],
            [['name', 'name_in_hindi', 'name_in_other_language', 'official_email', 'website', 'facebook_link', 'linkedin_link', 'twitter_link', 'logo'], 'string', 'max' => 190],
            [['code'], 'string', 'max' => 10],
            [['telephone_number', 'fax', 'extension_number',], 'string', 'max' => 50],
            [['ip'], 'string', 'max' => 20],
            [['geo_coordinates'], 'string', 'max' => 128],
            [['name', 'name_in_hindi'], 'unique', 'targetAttribute' => ['name', 'name_in_hindi']],
            [['twitter_link', 'facebook_link', 'linkedin_link', 'website'], 'url', 'defaultScheme' => 'http'],
            [['name', 'name_in_hindi', 'type', 'profile', 'address', 'official_email'], 'required', 'on' => 'bulk_upload_validate']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'parent_id' => Yii::t('app', 'Parent Unit'),
            'is_parent' => Yii::t('app', 'Is Parent'),
            'depth' => Yii::t('app', 'Depth'),
            'path' => Yii::t('app', 'Path'),
            'name' => Yii::t('app', 'Name'),
            'name_in_hindi' => Yii::t('app', 'Name In Hindi'),
            'name_in_other_language' => Yii::t('app', 'Name In Other Language'),
            'code' => Yii::t('app', 'Code'),
            'order' => Yii::t('app', 'Order'),
            'profile' => Yii::t('app', 'Profile'),
            'official_email' => Yii::t('app', 'Official Email'),
            'official_login_account_mapped' => Yii::t('app', 'Official Login Account Mapped'),
            'address' => Yii::t('app', 'Address'),
            'telephone_number' => Yii::t('app', 'Telephone Number'),
            'fax' => Yii::t('app', 'Fax'),
            'extension_number' => Yii::t('app', 'Extension Number'),
            'website' => Yii::t('app', 'Website'),
            'facebook_link' => Yii::t('app', 'Facebook Link'),
            'linkedin_link' => Yii::t('app', 'Linkedin Link'),
            'twitter_link' => Yii::t('app', 'Twitter Link'),
            'logo' => Yii::t('app', 'Logo'),
            'geo_coordinates' => Yii::t('app', 'Geo Coordinates'),
            'current_head' => Yii::t('app', 'Head'),
            'status' => Yii::t('app', 'Status'),
            'verified' => Yii::t('app', 'Verified'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'ip' => Yii::t('app', 'Ip'),
            'campus_id' => Yii::t('app', 'Campus'),
        ];
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

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['bulk_upload_validate'] = ['name', 'name_in_hindi', 'type', 'profile', 'address', 'official_email'];//Scenario Values Only Accepted
        return $scenarios;
    }
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        date_default_timezone_set("Asia/Kolkata");
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->ip = Yii::$app->request->getUserIP();
        if ($this->type == 1) {
            $this->depth = 1;
            $this->order = 1;
        } else {
            $this->category = CoreAdministrativeUnitTypeOption::getAdministrativeUnitTypeCategory($this->type);
            $this->depth = static::getParentDepth($this->parent_id) + 1;
            $this->path = static::getParentPath($this->parent_id);
            $this->order = static::getOrder($this->type, $this->parent_id);
            $this->official_login_account_mapped = 1;
            $this->current_head = 1;
            $this->verified = 1;
        }

        return true;
    }


    public static function getAll()
    {
        $models = self::find()->cache(7200)->where(['status' => 1])->all();
        if (!empty($models)) {
            return ArrayHelper::map($models, 'id', 'name');
        } else {
            return false;
        }
    }

    /**
     * getAllOu() - It will return list of all active Organizational Unit
     * @return array|bool
     */
    public static function getActiveOu()
    {
        $models = self::find()->cache(7200)
            ->where(['status' => 1])
            ->andWhere(['!=', 'type', 1])
            ->all();
        if (!empty($models)) {
            return ArrayHelper::map($models, 'id', 'name');
        } else {
            return false;
        }
    }

    /**
     * @param $type - Type for which all Parent OU list will be returned.
     * @return array - List of Parent OU, key-value pair
     */
    public static function getAllParentType($type)
    {
        if (!empty($type)) {
            $getParentID = CoreAdministrativeUnitTypeOption::getAdministrativeUnitTypeParent($type);
        } else {
            $getParentID = 1;
        }
        $models = self::find()->cache(7200)->where(['type' => $getParentID, 'status' => 1])->all();
        if (!empty($models)) {
            return ArrayHelper::map($models, 'id', 'name');
        } else {
            return [];
        }
    }

    /**
     * @param $type - Type for which all OU list will be returned.
     * @return array - List of OU, key-value pair
     */
    public static function getAllByType($type)
    {

        $models = self::find()->cache(7200)->where(['type' => $type])->all();
        if (!empty($models)) {
            return ArrayHelper::map($models, 'id', 'name');
        } else {
            return [];
        }
    }

    /**
     * @param $type - Type for which all OU list will be returned.
     * @return array - List of OU, key-value pair
     */
    public static function getActiveByType($type)
    {

        $models = self::find()->cache(7200)->where(['type' => $type, 'status' => 1])->all();
        if (!empty($models)) {
            return ArrayHelper::map($models, 'id', 'name');
        } else {
            return [];
        }
    }

    public static function resolveById($id)
    {
        $model = self::findOne($id);
        if (!empty($model)) {
            return $model->name;
        } else {
            return '';
        }
    }

    public static function getParentPath($parent_id)
    {
        $model = self::findOne($parent_id);
        if (!empty($model)) {
            return $model->path;
        } else {
            return '/';
        }
    }

    public static function getParentDepth($parent_id)
    {
        $model = self::findOne($parent_id);
        if (!empty($model)) {
            return $model->depth;
        } else {
            return 1;
        }
    }

    public static function getOrder($type, $parent_id)
    {
        $order = self::find()->where(['type' => $type, 'parent_id' => $parent_id])->count();
        return $order + 1;
    }

    public static function getTypeWiseount($type)
    {
        $count = self::find()->where(['type' => $type])->count();
        return $count;
    }

    public static function saveUniversityCampusDetail($u_model, $db)
    {
//        $model = new AdministrativeUnit();
//        $model->type = array_search('University', CoreAdministrativeUnitTypeOption::getAdministrativeUnitTypeList());//gets the key of the value from the array
//        $model->category = CoreAdministrativeUnitTypeOption::getAdministrativeUnitTypeCategory($model->type);
//        $model->is_parent = 1;
//        $model->name = $u_model->name;
//        $model->name_in_hindi = $u_model->name_in_hindi;
//        $model->code = $u_model->university_code;
//        $model->order = 1;
//        $model->profile = $u_model->details;
//        $model->address = $u_model->address;
//        $model->telephone_number = $u_model->head_contact;
//        $model->fax = $u_model->fax;
//        $model->extension_number = '';
//        $model->website = $u_model->website;
//        $model->facebook_link = $u_model->facebook;
//        $model->linkedin_link = $u_model->linkedin;
//        $model->twitter_link = $u_model->twitter;
//        $model->logo = $u_model->institution_logo;
//        $model->geo_coordinates = $u_model->geo_coordinates;
//        $model->current_head = 1;
//        $model->official_email = $u_model->head_email;
//        $model->status = 1;
//        $model->verified = 1;
//        $model->parent_id = 1;
//        if ($model->validate()) {
//            $db->createCommand($model->save());
//            $model->parent_id = $model->id;
//            $db->createCommand($model->save());
//            $model->path = '/' . $model->id;
//            $db->createCommand($model->updateAttributes(['path' => $model->path]));
        $camp_model = new AdministrativeUnit();
        $camp_model->type = array_search('Campus', CoreAdministrativeUnitTypeOption::getAdministrativeUnitTypeList());//gets the key of the value from the array
        $camp_model->category = CoreAdministrativeUnitTypeOption::getAdministrativeUnitTypeCategory($camp_model->type);
        $camp_model->is_parent = 1;
        $camp_model->name = 'University Campus';
        $camp_model->name_in_hindi = Yii::t('app', 'University Campus');
        $camp_model->code = $u_model->university_code;
        $camp_model->order = 1;
        $camp_model->profile = $u_model->details;
        $camp_model->address = $u_model->address;
        $camp_model->telephone_number = $u_model->head_contact;
        $camp_model->fax = $u_model->fax;
        $camp_model->extension_number = '';
        $camp_model->website = $u_model->website;
        $camp_model->facebook_link = $u_model->facebook;
        $camp_model->linkedin_link = $u_model->linkedin;
        $camp_model->twitter_link = $u_model->twitter;
        $camp_model->logo = $u_model->institution_logo;
        $camp_model->geo_coordinates = $u_model->geo_coordinates;
        $camp_model->current_head = 1;
        $camp_model->official_email = $u_model->head_email;
        $camp_model->status = 1;
        $camp_model->verified = 1;
        $camp_model->parent_id = 1;
        if ($camp_model->validate()) {
            $db->createCommand($camp_model->save());
            $camp_model->path = '/' . $camp_model->id;
//            $camp_model->parent_id = $camp_model->id;
            $db->createCommand($camp_model->updateAttributes(['path' => $camp_model->path, 'parent_id' => $camp_model->id]));
            return true;
        } else {
            throw new UserException(Yii::t('app', 'Please Try again later.'), 9000);
        }

    }

    public static function updateUniversityCampusDetail($u_model, $db, $old_name)
    {
        $model = static::findOne(['name' => $old_name, 'type' => 1]);
        if (!empty($model)) {
            $model->name = $u_model->name;
            $model->name_in_hindi = $u_model->name_in_hindi;
            $model->code = $u_model->university_code;
            $model->profile = $u_model->details;
            $model->address = $u_model->address;
            $model->telephone_number = $u_model->head_contact;
            $model->fax = $u_model->fax;
            $model->extension_number = '';
            $model->website = $u_model->website;
            $model->facebook_link = $u_model->facebook;
            $model->linkedin_link = $u_model->linkedin;
            $model->twitter_link = $u_model->twitter;
            $model->logo = $u_model->institution_logo;
            $model->geo_coordinates = $u_model->geo_coordinates;
            $model->current_head = 1;
            $model->official_email = $u_model->head_email;
            if ($model->validate()) {
                $db->createCommand($model->save());
            } else {
                throw new UserException(Yii::t('app', 'Please Try again later.'), 9000);
            }
        }
        $mmodel = static::findOne(['name' => 'University Campus', 'type' => 2]);
        if (!empty($mmodel)) {
            $mmodel->code = $u_model->university_code;
            $mmodel->profile = $u_model->details;
            $mmodel->address = $u_model->address;
            $mmodel->telephone_number = $u_model->head_contact;
            $mmodel->fax = $u_model->fax;
            $mmodel->extension_number = '';
            $mmodel->website = $u_model->website;
            $mmodel->facebook_link = $u_model->facebook;
            $mmodel->linkedin_link = $u_model->linkedin;
            $mmodel->twitter_link = $u_model->twitter;
            $mmodel->logo = $u_model->institution_logo;
            $mmodel->geo_coordinates = $u_model->geo_coordinates;
            $mmodel->current_head = 1;
            $mmodel->official_email = $u_model->head_email;
            if ($mmodel->validate()) {
                $db->createCommand($mmodel->save());
            } else {
                throw new UserException(Yii::t('app', 'Please Try again later.'), 9000);
            }
        }
    }

    /**
     * public static function getParentId($id)
     * It returns the ID of the Parent
     * @param $id - ID of the OU for which Parent ID will be returned
     * @return mixed|null - ID of parent , if parent exists else return NULL
     */
    public static function getParentId($id)
    {
        $model = self::find()->select('parent_id')->where(['id' => $id])->one();
        if (!empty($model)) {
            return $model->parent_id;
        } else {
            return NULL;
        }
    }

    public static function validateData($file_name)
    {
        date_default_timezone_set("Asia/Kolkata");

        $f_name = ApplicationControl::getVariable('excel_upload_path') . '/' . $file_name;
        $data = Excel::import("$f_name", ['getOnlySheet' => 'Sheet1']);
        try {
            $db = Yii::$app->db;
            $transaction = $db->beginTransaction();
            if (!empty($data)) {

                $count = 0;
                $total = 2;
                $error = '';
                foreach ($data as $key => $record) {
                    if ($count == 4) {
                        //  Break the Loop if consecutive 4 rows are empty from the excel
                        break;
                    }
                    // Condition to check whether the all the fields are empty.
                    if (empty(Html::encode($record['name'])) &&
                        empty(Html::encode($record['name_in_hindi'])) &&
                        empty(Html::encode($record['type'])) &&
                        empty(Html::encode($record['address'])) &&
                        empty(Html::encode($record['profile'])) &&
                        empty(Html::encode($record['official_email']))
                    ) {
                        $count++;
                        continue;
                        // Code to  continue the loop if the row is empty rather than printing
                    }
                    $model = new AdministrativeUnit();
                    $model->scenario = 'bulk_upload_validate';
                    $model->name = $record['name'];
                    $model->name_in_hindi = $record['name_in_hindi'];
                    $model->type = in_array($record['type'], CoreAdministrativeUnitTypeOption::getAdministrativeUnitTypeList()) ? array_search($record['type'], CoreAdministrativeUnitTypeOption::getAdministrativeUnitTypeList()) : null;
                    $model->address = $record['address'];
                    $model->profile = $record['profile'];
                    $model->official_email = $record['official_email'];
                    if ($model->validate()) {
                        $db->createCommand($model->save());
                    } else {
                        $error .= '<ul style="color: red;font-weight: bold"><li> For Row Number: ' . $total . ', ' . implode('</li><li> For Row Number: ' . $total . ', ', $model->getErrorSummary(true)) . '</li></ul>';
                    }
                    $total++;
                }

                if (!empty($error)) {
                    return [404, $error];
                }
            } else {
                return [404, Yii::t('app', 'No Data is Found')];
            }
            $transaction->commit();

            return [200, Yii::t('app', 'List Uploaded to the system successfully.')];
        } catch (\Exception $e) {
            $transaction->rollBack();
            return [404, Yii::t('app', $e->getMessage())];
        }
    }
    
    
    public static function resolveByName($title)
    {
        $result = static::find()->cache(7200)->where(['name' => $title])->one();
        if(!empty($result)){
            return $result->id;
        }else{
            return null;
        }
    }
}
