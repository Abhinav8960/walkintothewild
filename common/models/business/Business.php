<?php

namespace common\models\business;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "business".
 *
 * @property int $id
 * @property int $business_request_id
 * @property string $business_name
 * @property string|null $slug
 * @property string|null $address
 * @property string|null $logo
 * @property string|null $about_business
 * @property string|null $phone_no
 * @property string|null $email
 * @property string|null $alternate_phone_no
 * @property string|null $alternate_email
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class Business extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'business';
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
            [['slug', 'address', 'logo', 'about_business', 'phone_no', 'email', 'alternate_phone_no', 'alternate_email', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['business_request_id', 'business_name'], 'required'],
            [['business_request_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['about_business'], 'string'],
            [['business_name', 'address', 'logo', 'email', 'alternate_email'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 512],
            [['phone_no', 'alternate_phone_no'], 'string', 'max' => 12],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'business_request_id' => 'Business Request ID',
            'business_name' => 'Business Name',
            'slug' => 'Slug',
            'address' => 'Address',
            'logo' => 'Logo',
            'about_business' => 'About Business',
            'phone_no' => 'Phone No',
            'email' => 'Email',
            'alternate_phone_no' => 'Alternate Phone No',
            'alternate_email' => 'Alternate Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
