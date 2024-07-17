<?php

namespace common\models\operator\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorActivities;
use common\models\operator\SafariOperatorPark;
use common\models\registration\SafariOperatorRequest;
use common\models\registration\SafariOperatorRequestActivities;
use common\models\registration\SafariOperatorRequestPark;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Safari Operator
 */
class SafariOperatorRequestForm extends model
{
    public $park_id;
    public $category_id;
    public $safari_operator_id;
    public $budget_segment;
    public $business_name;
    public $register_comapany_name;
    public $address;
    // public $is_agree;
    public $gst;
    public $logo;
    public $is_highlighted;
    public $google_rating;
    public $google_review_count;
    public $google_business_url;
    public $google_business_name;
    public $about_business;
    public $facebook_url;
    public $instagram_url;
    public $youtube_link;
    public $phone_no;
    public $email;
    public $website;
    public $is_register_company;
    public $has_a_website;
    public $offers_other_wildlifeactivities;
    public $has_cancellation_policy;
    public $wildlife_photographer;
    public $wildlife_influencer;
    public $is_offer_premium_budget;
    public $is_offer_standard_budget;
    public $is_offer_economical_budget;
    public $starting_price;
    public $is_approved;
    public $operator_name;
    public $operator_phone_no;
    public $operator_email;
    public $registration_platform;
    public $user_id;

    public $status;
    public $status_option = [];
    public $safari_operator_model;
    public $safari_operator_request_model;


    public $reCaptcha;
    public $referrer_url;

    public $action_url;
    public $action_validate_url;

    public function __construct(SafariOperator $safari_operator_model)
    {

        $this->safari_operator_request_model = Yii::createObject([
            'class' => SafariOperatorRequest::className()
        ]);


        $this->safari_operator_model = Yii::createObject([
            'class' => SafariOperator::className()
        ]);



        if ($safari_operator_model  != '') {
            $this->safari_operator_model = $safari_operator_model;



            $this->category_id                                    =  $this->safari_operator_model->category_id;
            $this->safari_operator_id                             =  $this->safari_operator_model->id;
            $this->business_name                                  =  $this->safari_operator_model->business_name;
            $this->register_comapany_name                         =  $this->safari_operator_model->register_comapany_name;
            $this->address                                        =  $this->safari_operator_model->address;
            $this->gst                                            =  $this->safari_operator_model->gst;
            $this->logo                                           =  $this->safari_operator_model->logo;
            $this->is_highlighted                                 =  $this->safari_operator_model->is_highlighted;
            $this->google_rating                                  =  $this->safari_operator_model->google_rating;
            $this->google_review_count                            =  $this->safari_operator_model->google_review_count;
            $this->google_business_url                            =  $this->safari_operator_model->google_business_url;
            $this->google_business_name                           =  $this->safari_operator_model->google_business_name;
            $this->about_business                                 =  $this->safari_operator_model->about_business;
            $this->facebook_url                                   =  $this->safari_operator_model->facebook_url;
            $this->instagram_url                                  =  $this->safari_operator_model->instagram_url;
            $this->youtube_link                                   =  $this->safari_operator_model->youtube_link;
            $this->phone_no                                       =  $this->safari_operator_model->phone_no;
            $this->email                                          =  $this->safari_operator_model->email;
            $this->website                                        =  $this->safari_operator_model->website;
            $this->is_register_company                            =  $this->safari_operator_model->is_register_company;
            $this->has_a_website                                  =  $this->safari_operator_model->has_a_website;
            $this->has_cancellation_policy                        =  $this->safari_operator_model->has_cancellation_policy;
            $this->wildlife_photographer                          =  $this->safari_operator_model->wildlife_photographer;
            $this->wildlife_influencer                            =  $this->safari_operator_model->wildlife_influencer;
            $this->is_offer_premium_budget                        =  $this->safari_operator_model->is_offer_premium_budget;
            $this->is_offer_standard_budget                       =  $this->safari_operator_model->is_offer_standard_budget;
            $this->is_offer_economical_budget                     =  $this->safari_operator_model->is_offer_economical_budget;
            $this->starting_price                                 =  $this->safari_operator_model->starting_price;
            $this->is_approved                                    =  $this->safari_operator_model->is_approved;
            $this->operator_name                                  =  $this->safari_operator_model->operator_name;
            $this->operator_phone_no                              =  $this->safari_operator_model->operator_phone_no;
            $this->operator_email                                 =  $this->safari_operator_model->operator_email;
            $this->is_highlighted                                 =  $this->safari_operator_model->is_highlighted;
            $this->status                                         =  $this->safari_operator_model->status;
            $this->user_id                                         =  $this->safari_operator_model->user_id;
            // $this->is_agree                                       =  $this->safari_operator_model->is_agree;
            // $this->registration_platform                          =  $this->safari_operator_model->registration_platform;
            $this->park_id                                        = SafariOperatorPark::find()->select('park_id')->where(['safari_operator_id' => $this->safari_operator_model->id, 'status' => 1])->column();
            $this->offers_other_wildlifeactivities                = SafariOperatorActivities::find()->select('wildlife_activity_id')->where(['safari_operator_id' => $this->safari_operator_model->id, 'status' => 1])->column();

            if ($this->safari_operator_model->is_offer_premium_budget == true && $this->safari_operator_model->is_offer_standard_budget == true && $this->safari_operator_model->is_offer_economical_budget == true) {
                $this->budget_segment = [1, 2, 3];
            } else if ($this->safari_operator_model->is_offer_standard_budget == true && $this->safari_operator_model->is_offer_economical_budget == true) {
                $this->budget_segment = [2, 3];
            } else if ($this->safari_operator_model->is_offer_premium_budget == true && $this->safari_operator_model->is_offer_standard_budget == true) {
                $this->budget_segment = [1, 2];
            } else if ($this->safari_operator_model->is_offer_premium_budget == true && $this->safari_operator_model->is_offer_economical_budget == true) {
                $this->budget_segment = [1, 3];
            } else if ($this->safari_operator_model->is_offer_premium_budget == true) {
                $this->budget_segment[] = 1;
            } else if ($this->safari_operator_model->is_offer_standard_budget == true) {
                $this->budget_segment[] = 2;
            } else if ($this->safari_operator_model->is_offer_economical_budget == true) {
                $this->budget_segment[] = 3;
            }
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}is_offer_premium_budget
     */
    public function rules()
    {
        $rules = [
            [['category_id', 'safari_operator_id', 'is_highlighted', 'google_review_count', 'phone_no', 'is_register_company', 'has_a_website', 'has_cancellation_policy', 'wildlife_photographer', 'wildlife_influencer', 'is_offer_premium_budget', 'is_offer_standard_budget', 'is_offer_economical_budget', 'is_approved', 'status'], 'integer'],
            // [['is_agree'], 'required', 'requiredValue' => 1, 'message' => 'You must agree to the terms and conditions.'],

            [['business_name', 'phone_no', 'register_comapany_name', 'category_id', 'address', 'park_id', 'email', 'budget_segment'], 'required'],
            [['phone_no', 'operator_phone_no'], 'unique', 'targetClass' => 'common\models\registration\SafariOperatorRequest', 'message' => 'This phone has already been taken.', 'targetAttribute' => 'id'],
            [['phone_no', 'operator_phone_no'], 'match', 'pattern' => '/^[1234567890]\d{9}$/', 'message' => 'Invalid Phone number.'],
            [['facebook_url', 'instagram_url', 'youtube_link'], 'url'],
            [['operator_email', 'email'], 'email'],
            [['google_rating', 'starting_price'], 'number'],
            [['google_rating'], 'number', 'max' => 5],
            [['about_business'], 'string'],
            [['business_name', 'register_comapany_name', 'address', 'gst', 'google_business_url', 'google_business_name', 'facebook_url', 'instagram_url', 'youtube_link', 'email', 'website', 'operator_name', 'operator_phone_no', 'operator_email'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],
            [['is_highlighted', 'has_cancellation_policy', 'is_register_company', 'has_a_website', 'wildlife_photographer', 'wildlife_influencer', 'is_approved', 'starting_price', 'operator_name'], 'default', 'value' => 0],
            [['park_id', 'logo', 'budget_segment', 'offers_other_wildlifeactivities'], 'safe'],
            [['referrer_url', 'registration_platform'], 'safe'],
            [
                ['logo'], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
                // 'minWidth' => 500,
                // 'maxWidth' => 500,
                // 'maxHeight' => 123,
                // 'minHeight' => 123,
                'maxSize' => 250 * 1024
            ],
            ['about_business', \common\validators\Word120Validator::className()],
            ['phone_no', function () {
                if ($this->phone_no === $this->operator_phone_no) {
                    $this->addError('operator_phone_no', 'Phone Number Should not match');
                }
            }],
            ['email', function () {
                if ($this->email === $this->operator_email) {
                    $this->addError('operator_email', 'Email Should not match');
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
            'safari_operator_id' => 'Safari Operator ID',
            'business_name' => 'Business Name',
            'register_comapany_name' => 'Register Name',
            'address' => 'Address',
            'category_id' => 'Category Type',
            'park_id' => 'Park',
            'gst' => 'Gst',
            'logo' => 'Logo',
            'is_highlighted' => 'Is Highlighted',
            'google_rating' => 'Rating',
            'google_review_count' => 'Google Review Count',
            'google_business_url' => 'Google Business Url',
            'google_business_name' => 'Google Business Name',
            'about_business' => 'About Business',
            'facebook_url' => 'Facebook Url',
            'instagram_url' => 'Instagram Url',
            'youtube_link' => 'Youtube Link',
            'phone_no' => 'Phone No',
            'email' => 'Email',
            'website' => 'Website',
            'is_register_company' => 'Is Register Company',
            'has_a_website' => 'Has A Website',
            'offers_other_wildlifeactivities' => 'Offers Other Wildlifeactivities',
            'has_cancellation_policy' => 'Has Cancellation Policy',
            'wildlife_photographer' => 'Wildlife Photographer',
            'wildlife_influencer' => 'Wildlife Influencer',
            'is_offer_premium_budget' => 'Is Offer Premium Budget',
            'is_offer_standard_budget' => 'Is Offer Standard Budget',
            'is_offer_economical_budget' => 'Is Offer Economical Budget',
            'starting_price' => 'Starting Price',
            'is_approved' => 'Is Approved',
            'operator_name' => 'Operator Name',
            'operator_phone_no' => 'Operator Phone No',
            'operator_email' => 'Operator Email',
            'status' => 'Status',
        ];
    }
    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->safari_operator_request_model->category_id                     =  $this->category_id;
        $this->safari_operator_request_model->safari_operator_id              =  $this->safari_operator_id;
        $this->safari_operator_request_model->business_name                   =  $this->business_name;
        $this->safari_operator_request_model->register_comapany_name          =  $this->register_comapany_name;
        $this->safari_operator_request_model->address                         =  $this->address;
        $this->safari_operator_request_model->gst                             =  $this->gst;
        $this->safari_operator_request_model->is_highlighted                  =  $this->is_highlighted;
        $this->safari_operator_request_model->google_rating                   =  $this->google_rating;
        $this->safari_operator_request_model->google_review_count             =  $this->google_review_count;
        $this->safari_operator_request_model->google_business_url             =  $this->google_business_url;
        $this->safari_operator_request_model->google_business_name            =  $this->google_business_name;
        $this->safari_operator_request_model->about_business                  =  $this->about_business;
        $this->safari_operator_request_model->facebook_url                    =  $this->facebook_url;
        $this->safari_operator_request_model->instagram_url                   =  $this->instagram_url;
        $this->safari_operator_request_model->youtube_link                    =  $this->youtube_link;
        $this->safari_operator_request_model->phone_no                        =  $this->phone_no;
        $this->safari_operator_request_model->email                           =  $this->email;
        $this->safari_operator_request_model->website                         =  $this->website;
        $this->safari_operator_request_model->is_register_company             =  $this->is_register_company;
        $this->safari_operator_request_model->has_a_website                   =  $this->has_a_website;
        $this->safari_operator_request_model->has_cancellation_policy         =  $this->has_cancellation_policy;
        $this->safari_operator_request_model->wildlife_photographer           =  $this->wildlife_photographer;
        $this->safari_operator_request_model->wildlife_influencer             =  $this->wildlife_influencer;

        $this->safari_operator_request_model->is_offer_premium_budget         =  0;
        $this->safari_operator_request_model->is_offer_standard_budget        =  0;
        $this->safari_operator_request_model->is_offer_economical_budget      =  0;
        if (in_array(1, $this->budget_segment)) {
            $this->safari_operator_request_model->is_offer_premium_budget         =  1;
        }
        if (in_array(2, $this->budget_segment)) {
            $this->safari_operator_request_model->is_offer_standard_budget         =  1;
        }
        if (in_array(3, $this->budget_segment)) {
            $this->safari_operator_request_model->is_offer_economical_budget         =  1;
        }

        $this->safari_operator_request_model->starting_price                  =  $this->starting_price;
        // $this->safari_operator_request_model->is_approved                     =  $this->is_approved;
        $this->safari_operator_request_model->operator_name                   =  $this->operator_name;
        $this->safari_operator_request_model->operator_phone_no               =  $this->operator_phone_no;
        $this->safari_operator_request_model->operator_email                  =  $this->operator_email;
        $this->safari_operator_request_model->is_highlighted                  =  $this->is_highlighted;
        $this->safari_operator_request_model->user_id                  =  $this->user_id;
        $this->safari_operator_request_model->status                          =  1; //$this->status;
        // $this->safari_operator_request_model->is_agree                        =  $this->is_agree;
        $this->safari_operator_request_model->registration_platform           =  1;
    }





    public function uploadFile()
    {

        if ($this->logo) {
            $storagePath = Yii::$app->params['datapath'] . '/safarioperator';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->safari_operator_request_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'safarioperator' . time() . '.' . $this->logo->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->logo->saveAs($filePath)) {
                $this->safari_operator_request_model->logo = $fileName;
                $this->safari_operator_request_model->save(false);
            }
        }
    }
}
