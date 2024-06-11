<?php

namespace frontend\models;

use common\models\operator\OperatorQuote;
use common\models\operator\SafariOperator;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class OperatorQuoteForm extends Model
{
    public $safari_park_id;
    public $stay_category_id;
    public $start_date;
    public $end_date;
    public $full_name;
    public $email;
    public $phone_no;
    public $safaris;
    public $travelers;
    public $status;
    public $user_agent;
    public $ip_address;
    public $os;
    public $browser;
    public $device_type;
    public $action_url;
    public $action_validate_url;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['safari_park_id', 'safaris', 'travelers', 'stay_category_id', 'full_name', 'email', 'start_date', 'end_date', 'phone_no'], 'required'],
            [['phone_no'], 'match', 'pattern' => '/^[123456789]\d{9}$/', 'message' => 'Invalid Phone number.'],
            [['email'], 'email'],
            [['safari_park_id', 'safaris', 'travelers', 'stay_category_id', 'status'], 'integer'],
            [['full_name', 'email', 'start_date', 'end_date', 'user_agent'], 'string', 'max' => 255],
            [['phone_no'], 'string', 'max' => 12],
            [['safaris', 'travelers'], 'number', 'min' => 1],
            [['ip_address'], 'string', 'max' => 45],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'safari_park_id' => 'Safari Park',
            'safaris' => 'Safaris',
            'travelers' => 'Travelers',
            'stay_category_id' => 'Stay Category',
            'full_name' => 'Full Name',
            'email' => 'Email',
            'phone_no' => 'Phone No',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'user_agent' => 'User Agent',
            'ip_address' => 'Ip Address',
            'status' => 'Status',
        ];
    }


    /**
     * Save Contatc Query
     *
     * @param Corporate $corporate
     * @return void
     */
    public function request(SafariOperator $operator)
    {

        $agent = new \Jenssegers\Agent\Agent();
        $agent->setUserAgent(Yii::$app->request->userAgent);
        $operator_quote = new OperatorQuote();
        $operator_quote->safari_park_id = $this->safari_park_id;
        $operator_quote->safaris = $this->safaris;
        $operator_quote->travelers = $this->travelers;
        $operator_quote->stay_category_id = $this->stay_category_id;
        $operator_quote->full_name = $this->full_name;
        $operator_quote->email = $this->email;
        $operator_quote->start_date = $this->start_date;
        $operator_quote->end_date = $this->end_date;
        $operator_quote->phone_no = $this->phone_no;
        $operator_quote->operator_id = $operator->id;
        $operator_quote->ip_address = Yii::$app->getRequest()->getUserIp();
        $operator_quote->device_type = $agent->device();
        $operator_quote->user_agent =  Yii::$app->request->userAgent;
        $operator_quote->browser = $agent->browser();
        $operator_quote->os = $agent->platform();
        $operator_quote->status = 1;


        if ($operator_quote->save()) {
            return $operator_quote->save();
        }
    }
}
