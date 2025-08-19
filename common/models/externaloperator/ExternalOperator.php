<?php

namespace common\models\externaloperator;

use common\models\park\SafariPark;
use common\models\User;
use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "external_operator".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $operator_name
 * @property string|null $email
 * @property string|null $phone_no
 * @property string|null $website
 * @property string|null $address
 * @property string|null $owner_name
 * @property string|null $owner_email
 * @property string|null $owner_phone_no
 * @property string|null $traffic
 * @property string|null $engagement
 * @property string|null $seo_performance
 * @property string|null $google_rating
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class ExternalOperator extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{

    use CommanRelationship;


    const CALL_DONE = 1;
    const CALL_NOT_DONE = 0;
    const EMAIL_DONE = 1;
    const EMAIL_NOT_DONE = 0;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'external_operator';
    }

    
    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }


    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['operator_name', 'email', 'phone_no', 'website', 'address', 'owner_name', 'owner_email', 'owner_phone_no', 'traffic', 'engagement', 'seo_performance', 'google_rating', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['status','is_call_done','is_mail_send'], 'default', 'value' => 0],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by','is_call_done','is_mail_send'], 'integer'],
            [['operator_name', 'email', 'phone_no', 'website', 'owner_name', 'owner_email', 'owner_phone_no', 'traffic', 'engagement', 'seo_performance', 'google_rating'], 'string', 'max' => 255],
            [['address','comment'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'operator_name' => 'Operator Name',
            'email' => 'Email',
            'phone_no' => 'Phone No',
            'website' => 'Website',
            'address' => 'Address',
            'owner_name' => 'Owner Name',
            'owner_email' => 'Owner Email',
            'owner_phone_no' => 'Owner Phone No',
            'traffic' => 'Traffic',
            'engagement' => 'Engagement',
            'seo_performance' => 'Seo Performance',
            'google_rating' => 'Google Rating',
            'status' => 'Status',
            'is_call_done'=>'Is Call Done',
            'is_mail_send'=>'Is Mail Send',
            'comment'=>'Comment',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    public function getParkList(){
        return $this->hasMany(ExternalOperatorParks :: class , ['external_operator_id'=>'id']) ->where(['status' => 1])->orderBy(['id'=>SORT_DESC]);
    }

    public static function callstatusoption()
    {
        return [self::CALL_DONE => "YES", self::CALL_NOT_DONE => "NO"];
    }

    public static function emailstatusoption()
    {
        return [self::EMAIL_DONE => "YES", self::EMAIL_NOT_DONE => "NO"];
    }

    public function afterSave($insert, $changedAttributes)
    {
        $historyModel = new ExternalOperatorHistory();
        $historyModel->attributes = $this->attributes;
        $historyModel->parent_id = $this->id;

        if (!$historyModel->save(false)) {
            Yii::error('Failed to save User Post History: ' . print_r($historyModel->errors, true), __METHOD__);
        }
    }

}
