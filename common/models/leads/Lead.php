<?php

namespace common\models\leads;

use common\models\meta\MetaStayCategory;
use common\models\operator\SafariOperator;
use common\models\park\SafariPark;
use common\models\User;
use Yii;

/**
 * This is the model class for table "lead".
 *
 * @property int $id
 * @property int $source 1=>package,2=>park,3=>operator 
 * @property int|null $package_id
 * @property string $package_version
 * @property int|null $park_id
 * @property int|null $operator_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $destination
 * @property string $from_date
 * @property string $to_date
 * @property int $is_date_flexible
 * @property int $travelers
 * @property string|null $accommodation
 * @property string|null $transport
 * @property string|null $meals
 * @property string|null $budget
 * @property string|null $addional_notes
 * @property int $user_id
 * @property int $is_booking_for_login_user
 * @property int $is_seen_by_admin
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class Lead extends \yii\db\ActiveRecord
{

    const SOURCE_PACKAGE = 1;
    const SOURCE_PARK = 2;
    const SOURCE_PARTNER = 3;


    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lead';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['package_id', 'package_version', 'name', 'email', 'phone', 'park_id', 'destination', 'from_date',  'operator_id', 'safaris', 'stay_category_id', 'transport', 'meals', 'budget', 'addional_notes', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['is_seen_by_admin'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['source', 'package_version', 'name', 'email', 'phone', 'destination', 'from_date', 'to_date', 'user_id'], 'required'],
            [['source', 'package_id', 'park_id', 'operator_id', 'is_date_flexible', 'travelers', 'user_id', 'is_booking_for_login_user', 'is_seen_by_admin', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'safaris', 'stay_category_id'], 'integer'],
            [['from_date', 'to_date'], 'safe'],
            [['addional_notes'], 'string'],
            [['name', 'email', 'destination', 'transport', 'meals', 'budget'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source' => 'Source',
            'package_id' => 'Package ID',
            'package_version' => 'Package Version',
            'park_id' => 'Park ID',
            'operator_id' => 'Operator ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'destination' => 'Destination',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
            'is_date_flexible' => 'Is Date Flexible',
            'travelers' => 'Travelers',
            'safaris' => 'Safaris',
            'stay_category_id' => 'Accommodation',
            'transport' => 'Transport',
            'meals' => 'Meals',
            'budget' => 'Budget',
            'addional_notes' => 'Addional Notes',
            'user_id' => 'User ID',
            'is_booking_for_login_user' => 'Is Booking For Login User',
            'is_seen_by_admin' => 'Is Seen By Admin',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'safari_park_id']);
    }

    public function getOperator()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'operator_id']);
    }

    public function getStaycatgory()
    {
        return $this->hasOne(MetaStayCategory::className(), ['id' => 'stay_category_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
