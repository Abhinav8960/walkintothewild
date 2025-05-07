<?php

namespace common\models\quatation\form;

use common\models\quatation\Lead;
use Yii;
use yii\base\Model;

/**
 * This is the model class for table "quotation_requests".
 *
 * @property int $id
 * @property int|null $package_id
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
class LeadForm extends Model
{
    const SCENARIO_PACKAGE_LEAD = "package";
    const SCENARIO_PARK_LEAD = "park";
    const SCENARIO_OPERATOR_LEAD = "operator";

    

    public $type;
    public $package_id;
    public $park_id;
    public $operator_id;
    public $name;
    public $email;
    public $phone;
    public $destination;
    public $from_date;
    public $to_date;
    public $is_date_flexible;
    public $travelers;
    public $accommodation;
    public $transport;
    public $meals;
    public $budget;
    public $addional_notes;
    public $user_id;
    public $is_booking_for_login_user;
    public $status;
    public $created_at;
    public $updated_at;
    public $created_by;
    public $updated_by;
    public $form_model;

    public function __construct(Lead $form_model = null)
    {
        $this->form_model = Yii::createObject([
            'class' => Lead::className()
        ]);

        $this->travelers              =  1;
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['budget', 'addional_notes', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['is_date_flexible'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['name', 'email', 'phone', 'destination', 'from_date', 'to_date'], 'required'],
            [['type','is_date_flexible', 'travelers', 'user_id', 'is_booking_for_login_user', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['from_date', 'to_date', 'accommodation', 'transport', 'meals', 'user_id'], 'safe'],
            [['addional_notes'], 'string'],
            [['name', 'email', 'destination', 'accommodation', 'transport', 'meals', 'budget'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            ['email', 'email'],
            ['from_date', 'compare', 'compareValue' => date("Y-m-d"), 'operator' => '>'],
            ['to_date', 'compare', 'compareAttribute' => 'from_date', 'operator' => '>'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
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
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function save()
    {
        $model = new Lead();
        $model->package_id = $this->package_id;
        $model->park_id = $this->park_id;
        $model->operator_id = $this->operator_id;
        $model->name = $this->name;
        $model->email = $this->email;
        $model->phone = $this->phone;
        $model->destination = $this->destination;
        $model->from_date = $this->from_date;
        $model->to_date = $this->to_date;
        $model->is_date_flexible = $this->is_date_flexible;
        $model->travelers = $this->travelers;
        $model->accommodation = $this->accommodation;
        $model->transport = $this->transport;
        $model->meals = $this->meals;
        $model->budget = $this->budget;
        $model->addional_notes = $this->addional_notes;
        $model->user_id = $this->user_id;
        $model->is_booking_for_login_user = $this->is_booking_for_login_user;
        $model->status = 1;
        $model->user_id = \Yii::$app->user->identity->id;
        return $model->save(false);
    }
}
