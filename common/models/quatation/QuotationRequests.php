<?php

namespace common\models\quatation;

use Yii;

/**
 * This is the model class for table "quotation_requests".
 *
 * @property int $id
 * @property string $objective
 * @property int|null $collection
 * @property int|null $collection_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $destination
 * @property string $from_date
 * @property string $to_date
 * @property int $is_date_flexible
 * @property int $travelers
 * @property string $accommodation
 * @property string $transport
 * @property string $meals
 * @property string|null $budget
 * @property string|null $addional_notes
 * @property int $user_id
 * @property int $is_booking_for_login_user
 * @property int $travelers_nationality
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class QuotationRequests extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
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
    public static function tableName()
    {
        return 'quotation_requests';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['collection', 'collection_id', 'budget', 'addional_notes', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['is_date_flexible','is_seen_by_admin'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['name', 'email', 'phone', 'destination', 'from_date', 'to_date'], 'required'],
            [['collection', 'collection_id', 'is_date_flexible', 'travelers', 'user_id', 'is_booking_for_login_user', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by','is_seen_by_admin'], 'integer'],
            [['objective', 'from_date', 'to_date', 'accommodation', 'transport', 'meals', 'collection', 'collection_id', 'user_id'], 'safe'],
            [['addional_notes'], 'string'],
            [['objective', 'name', 'email', 'destination', 'accommodation', 'transport', 'meals', 'budget', 'travelers_nationality'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            ['email', 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'objective' => 'Objective',
            'collection' => 'Collection',
            'collection_id' => 'Collection ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'destination' => 'Destination',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
            'is_date_flexible' => 'Is Date Flexible',
            'travelers' => 'Travelers',
            'accommodation' => 'Accommodation',
            'transport' => 'Transport',
            'meals' => 'Meals',
            'budget' => 'Budget',
            'addional_notes' => 'Addional Notes',
            'user_id' => 'User ID',
            'is_booking_for_login_user' => 'Is Booking For Login User',
            'travelers_nationality' => 'Travelers Nationality',
            'is_seen_by_admin' => 'Is Seen By Admin',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);
    }
}
