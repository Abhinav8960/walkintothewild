<?php

namespace common\models\leads;

use common\models\meta\MetaStayCategory;
use common\models\operator\SafariOperator;
use common\models\package\Package;
use common\models\park\SafariPark;
use common\models\User;
use Yii;

/**
 * This is the model class for table "lead".
 *
 * @property int $id
 * @property int $source 1=>package,2=>park,3=>operator 
 * @property int|null $package_id
 * @property string|null $package_version
 * @property int|null $park_id
 * @property int|null $operator_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $destination
 * @property string $from_date
 * @property string|null $to_date
 * @property int $is_date_flexible
 * @property int|null $safaris
 * @property int $travelers
 * @property int|null $stay_category_id
 * @property string|null $transport
 * @property string|null $meals
 * @property string|null $budget
 * @property string|null $addional_notes
 * @property int $user_id
 * @property int $is_booking_for_login_user
 * @property int $is_seen_by_admin
 * @property int $status
 * @property int $is_payment_received
 * @property int $booked_operator_id
 * @property string|null $transaction_id
 * @property string|null $transaction_datetime
 * @property int $payment_gateway 1=>payu,2=>hdfc
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class Lead extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
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

    // /**
    //  * {@inheritdoc}
    //  */
    // public function rules()
    // {
    //     return [
    //         [['package_id', 'package_version', 'park_id', 'addional_notes', 'name', 'email', 'phone', 'park_id', 'destination', 'from_date',  'operator_id', 'safaris', 'stay_category_id', 'transport', 'meals', 'budget', 'addional_notes', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
    //         [['is_seen_by_admin'], 'default', 'value' => 0],
    //         [['status'], 'default', 'value' => 1],
    //         [['source', 'package_version', 'name', 'email', 'phone', 'destination', 'from_date', 'to_date', 'user_id'], 'required'],
    //         [['source', 'package_id', 'park_id', 'operator_id', 'is_date_flexible', 'travelers', 'user_id', 'is_booking_for_login_user', 'is_seen_by_admin', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'safaris', 'stay_category_id'], 'integer'],
    //         [['from_date', 'to_date'], 'safe'],
    //         [['addional_notes'], 'string'],
    //         [['name', 'email', 'destination', 'transport', 'meals', 'budget'], 'string', 'max' => 255],
    //         [['phone'], 'string', 'max' => 50],
    //     ];
    // }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['package_id', 'package_version', 'park_id', 'operator_id', 'name', 'email', 'phone', 'user_notes', 'destination', 'to_date', 'safaris', 'stay_category_id', 'transport', 'meals', 'budget', 'addional_notes', 'transaction_id', 'transaction_datetime', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['is_payment_received'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['source', 'from_date', 'user_id', 'booked_operator_id', 'payment_gateway'], 'required'],
            [['source', 'package_id', 'park_id', 'operator_id', 'is_date_flexible', 'safaris', 'travelers', 'stay_category_id', 'user_id', 'is_booking_for_login_user', 'is_seen_by_admin', 'status', 'is_payment_received', 'booked_operator_id', 'payment_gateway', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['from_date', 'to_date', 'transaction_datetime'], 'safe'],
            [['addional_notes'], 'string'],
            [['package_version'], 'string', 'max' => 10],
            [['name', 'email', 'destination', 'transport', 'meals', 'budget', 'transaction_id'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            [['user_notes'], 'string', 'max' => 1000],

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
            'safaris' => 'Safaris',
            'travelers' => 'Travelers',
            'stay_category_id' => 'Stay Category ID',
            'transport' => 'Transport',
            'meals' => 'Meals',
            'budget' => 'Budget',
            'addional_notes' => 'Addional Notes',
            'user_id' => 'User ID',
            'is_booking_for_login_user' => 'Is Booking For Login User',
            'is_seen_by_admin' => 'Is Seen By Admin',
            'status' => 'Status',
            'is_payment_received' => 'Is Payment Received',
            'booked_operator_id' => 'Booked Operator ID',
            'transaction_id' => 'Transaction ID',
            'transaction_datetime' => 'Transaction Datetime',
            'payment_gateway' => 'Payment Gateway',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id']);
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
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getAssignOperator()
    {
        return $this->hasMany(LeadPartners::className(), ['lead_id' => 'id']);
    }

    public function getSources()
    {
        return $arr = [
            SELF::SOURCE_PACKAGE => 'Package',
            SELF::SOURCE_PARK => 'Park',
            SELF::SOURCE_PARTNER => 'Partner',
        ];
    }

    public function getSourceLabel()
    {
        return $this->getSources()[$this->source] ?? 'uncategorized';
    }


    public function getQuotation()
    {
        return $this->hasMany(LeadPartnerQuotes::className(), ['lead_id' => 'id']);
    }

    public function getDisplayLabel()
    {
        if ($this->source == 1) {
            // if ($this->package) {
            //     return '<a href="' . Yii::$app->params['frontend_url'] . '/package/' . $this->package->package_slug . '" style="color: blue;">' . $this->package->package_name . '</a>';
            // }
            // return '';
            return $this->package ? $this->package->package_name : '';
        } else if ($this->source == 2) {
            return $this->park ? $this->park->title : '';
        } else if ($this->source == 3) {
            return $this->operator ? $this->operator->business_name : '';
        }
    }

    public function getSourceLabelWithBadge()
    {
        if ($this->source == 1) {
            return '<div style="display:flex; gap:14px; align-items:center"><span class="package-badge"></span>' . ' ' . 'Package</div>';
        } else if ($this->source == 2) {
            return '<div style="display:flex; gap:14px;align-items:center"><span class="park-badge"></span>' . ' ' . 'Park</div>';
        } else if ($this->source == 3) {
            return '<div style="display:flex; gap:14px;align-items:center"><span class="operator-badge"></span>' . ' ' . 'Operator</div>';
        }
    }

    public function getDisplayImage()
    {
        if ($this->source == 1) {
            return $this->package ? $this->package->imagepath : '';
        } else if ($this->source == 2) {
            return $this->park ? $this->park->Logoimagepath : '';
        } else if ($this->source == 3) {
            return $this->operator ? $this->operator->imagepath : '';
        }
    }

    public function getDisplayColor()
    {
        $style = 'width: 40%;';
        if ($this->source == 1) {
            $style .= 'background-color: #009FFF !important;';
        } else if ($this->source == 2) {
            $style .= 'background-color: #C4E3BD !important;';
        } else if ($this->source == 3) {
            $style .= 'background-color:rgb(175, 175, 175) !important;';
        }

        return $style;
    }


    public function getDisplayOverview()
    {
        if ($this->source == 1) {
            return $this->package ? mb_strimwidth($this->package->package_description, 0, 400, "...") : '';
        } else if ($this->source == 2) {
            return $this->park ? mb_strimwidth($this->park->short_description, 0, 400, "...") : '';
        } else if ($this->source == 3) {
            return $this->operator ? mb_strimwidth($this->operator->about_business, 0, 400, "...") : '';
        }
    }

    public function getPackage()
    {
        return $this->hasOne(Package::className(), ['id' => 'package_id', 'live_version' => 'package_version']);
    }

    public function getBookedpartner()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'booked_operator_id']);
    }
}
