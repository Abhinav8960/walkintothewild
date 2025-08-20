<?php

namespace common\models\operator\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorActivities;
use common\models\operator\SafariOperatorPark;
use common\models\registration\SafariOperatorRequestActivities;
use common\models\registration\SafariOperatorRequestPark;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Safari Operator
 */
class SafariOperatorForm extends model
{
    public $id;
    public $park_id;
    public $safari_operator_request_id;
    public $category_id;
    public $business_name;
    public $budget_segment;
    public $register_comapany_name;
    public $address;
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
    public $has_cancellation_policy;
    public $offers_other_wildlifeactivities;
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
    public $status;

    public $status_option = [];
    public $safarioperator_model;

    public $reCaptcha;
    public $referrer_url;

    public $action_url;
    public $action_validate_url;

    public function __construct(SafariOperator $safarioperator_model)
    {

        $this->safarioperator_model = Yii::createObject([
            'class' => SafariOperator::className()
        ]);



        if ($safarioperator_model  != '') {
            $this->safarioperator_model = $safarioperator_model;



            $this->id                                             =  $this->safarioperator_model->id;
            $this->category_id                                    =  $this->safarioperator_model->category_id;
            $this->business_name                                  =  $this->safarioperator_model->business_name;
            $this->register_comapany_name                         =  $this->safarioperator_model->register_comapany_name;
            $this->address                                        =  $this->safarioperator_model->address;
            $this->gst                                            =  $this->safarioperator_model->gst;
            $this->logo                                           =  $this->safarioperator_model->logo;
            $this->is_highlighted                                 =  $this->safarioperator_model->is_highlighted;
            $this->google_rating                                  =  $this->safarioperator_model->google_rating;
            $this->google_review_count                            =  $this->safarioperator_model->google_review_count;
            $this->google_business_url                            =  $this->safarioperator_model->google_business_url;
            $this->google_business_name                           =  $this->safarioperator_model->google_business_name;
            $this->about_business                                 =  $this->safarioperator_model->about_business;
            $this->facebook_url                                   =  $this->safarioperator_model->facebook_url;
            $this->instagram_url                                  =  $this->safarioperator_model->instagram_url;
            $this->youtube_link                                   =  $this->safarioperator_model->youtube_link;
            $this->phone_no                                       =  $this->safarioperator_model->phone_no;
            $this->email                                          =  $this->safarioperator_model->email;
            $this->website                                        =  $this->safarioperator_model->website;
            $this->is_register_company                            =  $this->safarioperator_model->is_register_company;
            $this->has_a_website                                  =  $this->safarioperator_model->has_a_website;
            $this->has_cancellation_policy                        =  $this->safarioperator_model->has_cancellation_policy;
            $this->wildlife_photographer                          =  $this->safarioperator_model->wildlife_photographer;
            $this->wildlife_influencer                            =  $this->safarioperator_model->wildlife_influencer;
            $this->is_offer_premium_budget                        =  $this->safarioperator_model->is_offer_premium_budget;
            $this->is_offer_standard_budget                       =  $this->safarioperator_model->is_offer_standard_budget;
            $this->is_offer_economical_budget                     =  $this->safarioperator_model->is_offer_economical_budget;
            $this->starting_price                                 =  $this->safarioperator_model->starting_price;
            $this->is_approved                                    =  $this->safarioperator_model->is_approved;
            $this->operator_name                                  =  $this->safarioperator_model->operator_name;
            $this->operator_phone_no                              =  $this->safarioperator_model->operator_phone_no;
            $this->operator_email                                 =  $this->safarioperator_model->operator_email;
            $this->is_highlighted                                 =  $this->safarioperator_model->is_highlighted;
            $this->offers_other_wildlifeactivities                = SafariOperatorActivities::find()->select('wildlife_activity_id')->where(['safari_operator_id' => $this->safarioperator_model->id, 'status' => 1])->column();
            $this->park_id                                        = SafariOperatorPark::find()->select('park_id')->where(['safari_operator_id' => $this->safarioperator_model->id, 'status' => 1])->column();

            $this->status                                         =  $this->safarioperator_model->status;

            if ($this->safarioperator_model->is_offer_premium_budget == true && $this->safarioperator_model->is_offer_standard_budget == true && $this->safarioperator_model->is_offer_economical_budget == true) {
                $this->budget_segment = [1, 2, 3];
            } else if ($this->safarioperator_model->is_offer_standard_budget == true && $this->safarioperator_model->is_offer_economical_budget == true) {
                $this->budget_segment = [2, 3];
            } else if ($this->safarioperator_model->is_offer_premium_budget == true && $this->safarioperator_model->is_offer_standard_budget == true) {
                $this->budget_segment = [1, 2];
            } else if ($this->safarioperator_model->is_offer_premium_budget == true && $this->safarioperator_model->is_offer_economical_budget == true) {
                $this->budget_segment = [1, 3];
            } else if ($this->safarioperator_model->is_offer_premium_budget == true) {
                $this->budget_segment[] = 1;
            } else if ($this->safarioperator_model->is_offer_standard_budget == true) {
                $this->budget_segment[] = 2;
            } else if ($this->safarioperator_model->is_offer_economical_budget == true) {
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
            [['category_id', 'id', 'is_highlighted', 'google_review_count', 'phone_no', 'is_register_company', 'has_a_website', 'has_cancellation_policy', 'wildlife_photographer', 'wildlife_influencer', 'is_offer_premium_budget', 'is_offer_standard_budget', 'is_offer_economical_budget', 'is_approved', 'status'], 'integer'],


            [['business_name', 'phone_no', 'register_comapany_name', 'category_id', 'address', 'park_id', 'email'], 'required'],
            [['phone_no', 'operator_phone_no'], 'unique', 'targetClass' => 'common\models\registration\SafariOperatorRequest', 'message' => 'This phone has already been taken.', 'targetAttribute' => 'id'],
            [['phone_no', 'operator_phone_no'], 'match', 'pattern' => '/^[1234567890]\d{9}$/', 'message' => 'Invalid Phone number.'],
            [['facebook_url', 'instagram_url', 'youtube_link'], 'url'],
            [['operator_email', 'email'], 'email'],
            [['google_rating', 'starting_price'], 'number'],
            [['google_rating'], 'number', 'max' => 5],
            [['about_business'], 'string'],
            [['business_name', 'register_comapany_name', 'address', 'gst', 'google_business_url', 'google_business_name', 'facebook_url', 'instagram_url', 'youtube_link', 'email', 'website', 'operator_name', 'operator_phone_no', 'operator_email'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],
            [['is_highlighted', 'has_cancellation_policy', 'is_register_company', 'has_a_website', 'wildlife_photographer', 'wildlife_influencer', 'is_approved','starting_price', 'operator_name'], 'default', 'value' => 0],
            [['park_id', 'logo', 'budget_segment', 'offers_other_wildlifeactivities'], 'safe'],
            [['referrer_url', 'registration_platform'], 'safe'],
            [
                ['logo'],
                'image',
                'extensions' => ['jpeg', 'jpg', 'png'],
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
            [['website', 'instagram_url', 'facebook_url', 'youtube_link'], 'url', 'defaultScheme' => 'http'],
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
        $this->safarioperator_model->id                              =  $this->id;
        $this->safarioperator_model->category_id                     =  $this->category_id;
        $this->safarioperator_model->business_name                   =  $this->business_name;
        $this->safarioperator_model->register_comapany_name          =  $this->register_comapany_name;
        $this->safarioperator_model->address                         =  $this->address;
        $this->safarioperator_model->gst                             =  $this->gst;
        $this->safarioperator_model->is_highlighted                  =  $this->is_highlighted;
        $this->safarioperator_model->google_rating                   =  $this->google_rating;
        $this->safarioperator_model->google_review_count             =  $this->google_review_count;
        $this->safarioperator_model->google_business_url             =  $this->google_business_url;
        $this->safarioperator_model->google_business_name            =  $this->google_business_name;
        $this->safarioperator_model->about_business                  =  $this->about_business;
        $this->safarioperator_model->facebook_url                    =  $this->facebook_url;
        $this->safarioperator_model->instagram_url                   =  $this->instagram_url;
        $this->safarioperator_model->youtube_link                    =  $this->youtube_link;
        $this->safarioperator_model->phone_no                        =  $this->phone_no;
        $this->safarioperator_model->email                           =  $this->email;
        $this->safarioperator_model->website                         =  $this->website;
        $this->safarioperator_model->is_register_company             =  $this->is_register_company;
        $this->safarioperator_model->has_a_website                   =  $this->has_a_website;
        $this->safarioperator_model->has_cancellation_policy         =  $this->has_cancellation_policy;
        $this->safarioperator_model->wildlife_photographer           =  $this->wildlife_photographer;
        $this->safarioperator_model->wildlife_influencer             =  $this->wildlife_influencer;

        $this->safarioperator_model->is_offer_premium_budget         =  0;
        $this->safarioperator_model->is_offer_standard_budget        =  0;
        $this->safarioperator_model->is_offer_economical_budget      =  0;

        if (in_array(1, $this->budget_segment)) {
            $this->safarioperator_model->is_offer_premium_budget         =  1;
        }
        if (in_array(2, $this->budget_segment)) {
            $this->safarioperator_model->is_offer_standard_budget         =  1;
        }
        if (in_array(3, $this->budget_segment)) {
            $this->safarioperator_model->is_offer_economical_budget         =  1;
        }


        $this->safarioperator_model->starting_price                  =  $this->starting_price;
        $this->safarioperator_model->is_approved                     =  $this->is_approved;
        $this->safarioperator_model->operator_name                   =  $this->operator_name;
        $this->safarioperator_model->operator_phone_no               =  $this->operator_phone_no;
        $this->safarioperator_model->operator_email                  =  $this->operator_email;
        $this->safarioperator_model->is_highlighted                  =  $this->is_highlighted;

        $this->safarioperator_model->status                          =  $this->status;
    }





    public function uploadFile()
    {

        if ($this->logo) {
            $storagePath = Yii::$app->params['datapath'] . '/safarioperator';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->safarioperator_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'safarioperator' . time() . '.' . $this->logo->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->logo->saveAs($filePath)) {
                $this->safarioperator_model->logo = $fileName;
                $this->safarioperator_model->save(false);
            }
        }
    }
}
