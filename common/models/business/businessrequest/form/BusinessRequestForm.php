<?php

namespace common\models\business\businessrequest\form;

use common\models\business\businessrequest\BusinessRequest;
use Yii;
use yii\base\Model;

class BusinessRequestForm extends Model
{
    public $business_name;
    public $address;
    public $logo;
    public $about_business;
    public $phone_no;
    public $email;
    public $is_approved;
    public $alternate_phone_no;
    public $alternate_email;
    public $status;
    public $reCaptcha;


    public $business_request_model;

    /**
     * @param [type] $business_request_model
     */
    public function __construct(BusinessRequest $business_request_model = null)
    {
        $this->business_request_model = Yii::createObject([
            'class' => BusinessRequest::className()
        ]);
        if ($business_request_model != null) {
            $this->business_request_model = $business_request_model;
            $this->business_name = $this->business_request_model->business_name;
            $this->address = $this->business_request_model->address;
            $this->about_business = $this->business_request_model->about_business;
            $this->phone_no = $this->business_request_model->phone_no;
            $this->email = $this->business_request_model->email;
            $this->alternate_phone_no = $this->business_request_model->alternate_phone_no;
            $this->alternate_email = $this->business_request_model->alternate_email;
            $this->is_approved = $this->business_request_model->is_approved;
            $this->status = $this->business_request_model->status;
        }
    }

    public function rules()
    {
        $rules = [
            [['business_name', 'phone_no', 'email'], 'required'],
            [['about_business'], 'string'],
            [['status'], 'integer'],
            [['business_name', 'address'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],
            [['phone_no', 'alternate_phone_no'], 'match', 'pattern' => '/^[1234567890]\d{9}$/', 'message' => 'Invalid Phone number.'],
            [['alternate_email', 'email'], 'email'],
            ['phone_no', function () {
                if ($this->phone_no === $this->alternate_phone_no) {
                    $this->addError('alternate_phone_no', 'Phone Number Should not match');
                }
            }],
            ['email', function () {
                if ($this->email === $this->alternate_email) {
                    $this->addError('alternate_email', 'Email Should not match');
                }
            }],
        ];
        if (\Yii::$app->params['isGoogleV3CaptchaValidateNeeded'] == true) {
            $rules[] = [['reCaptcha'], \kekaadrenalin\recaptcha3\ReCaptchaValidator::className(), 'acceptance_score' => 0];
        }
        return $rules;
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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
        ];
    }

    /**
     * Initialize Form Model
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->business_request_model->business_name = $this->business_name;
        $this->business_request_model->address = $this->address;
        $this->business_request_model->about_business = $this->about_business;
        $this->business_request_model->phone_no = $this->phone_no;
        $this->business_request_model->email = $this->email;
        $this->business_request_model->is_approved = $this->is_approved;
        $this->business_request_model->alternate_phone_no = $this->alternate_phone_no;
        $this->business_request_model->alternate_email = $this->alternate_email;
        $this->business_request_model->status = $this->status;
    }
}
