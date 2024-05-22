<?php

namespace frontend\models\registration\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use frontend\models\registration\SafariOperatorRequest;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Holiday
 */
class SafarotourRegistrationForm extends model
{
    public $park_id;
    public $category_id;
    public $safari_operator_id;
    public $business_name;
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

    public $status;
    public $status_option = [];
    public $safarioperator_request_model;


    public function __construct(SafariOperatorRequest $safarioperator_request_model = null)
    {

        $this->safarioperator_request_model = Yii::createObject([
            'class' => SafariOperatorRequest::className()
        ]);



        if ($safarioperator_request_model  != '') {
            $this->safarioperator_request_model = $safarioperator_request_model;



            $this->category_id              =  $this->safarioperator_request_model->category_id;
            $this->safari_operator_id              =  $this->safarioperator_request_model->safari_operator_id;
            $this->business_name                   =  $this->safarioperator_request_model->business_name;
            $this->register_comapany_name          =  $this->safarioperator_request_model->register_comapany_name;
            $this->address                         =  $this->safarioperator_request_model->address;
            $this->gst                             =  $this->safarioperator_request_model->gst;
            $this->logo                            =  $this->safarioperator_request_model->logo;
            $this->is_highlighted                  =  $this->safarioperator_request_model->is_highlighted;
            $this->google_rating                   =  $this->safarioperator_request_model->google_rating;
            $this->google_review_count             =  $this->safarioperator_request_model->google_review_count;
            $this->google_business_url             =  $this->safarioperator_request_model->google_business_url;
            $this->google_business_name            =  $this->safarioperator_request_model->google_business_name;
            $this->about_business                  =  $this->safarioperator_request_model->about_business;
            $this->facebook_url                    =  $this->safarioperator_request_model->facebook_url;
            $this->instagram_url                   =  $this->safarioperator_request_model->instagram_url;
            $this->youtube_link                    =  $this->safarioperator_request_model->youtube_link;
            $this->phone_no                        =  $this->safarioperator_request_model->phone_no;
            $this->email                           =  $this->safarioperator_request_model->email;
            $this->website                         =  $this->safarioperator_request_model->website;
            $this->is_register_company             =  $this->safarioperator_request_model->is_register_company;
            $this->has_a_website                   =  $this->safarioperator_request_model->has_a_website;
            $this->offers_other_wildlifeactivities =  $this->safarioperator_request_model->offers_other_wildlifeactivities;
            $this->has_cancellation_policy         =  $this->safarioperator_request_model->has_cancellation_policy;
            $this->wildlife_photographer           =  $this->safarioperator_request_model->wildlife_photographer;
            $this->wildlife_influencer             =  $this->safarioperator_request_model->wildlife_influencer;
            $this->is_offer_premium_budget         =  $this->safarioperator_request_model->is_offer_premium_budget;
            $this->is_offer_standard_budget        =  $this->safarioperator_request_model->is_offer_standard_budget;
            $this->is_offer_economical_budget      =  $this->safarioperator_request_model->is_offer_economical_budget;
            $this->starting_price                  =  $this->safarioperator_request_model->starting_price;
            $this->is_approved                     =  $this->safarioperator_request_model->is_approved;
            $this->operator_name                   =  $this->safarioperator_request_model->operator_name;
            $this->operator_phone_no               =  $this->safarioperator_request_model->operator_phone_no;
            $this->operator_email                  =  $this->safarioperator_request_model->operator_email;
            $this->status                          =  $this->safarioperator_request_model->this->safarioperator_request_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {


        return [
            [['category_id', 'safari_operator_id', 'is_highlighted', 'google_review_count', 'phone_no', 'is_register_company', 'has_a_website', 'offers_other_wildlifeactivities', 'has_cancellation_policy', 'wildlife_photographer', 'wildlife_influencer', 'is_offer_premium_budget', 'is_offer_standard_budget', 'is_offer_economical_budget', 'is_approved', 'status'], 'integer'],
            [['business_name', 'phone_no', 'operator_name', 'operator_phone_no', 'operator_email', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'required'],
            [['google_rating', 'starting_price'], 'number'],
            [['about_business'], 'string'],
            [['business_name', 'register_comapany_name', 'address', 'gst', 'logo', 'google_business_url', 'google_business_name', 'facebook_url', 'instagram_url', 'youtube_link', 'email', 'website', 'operator_name', 'operator_phone_no', 'operator_email'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],
            [['park_id'], 'safe']
        ];
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
            'register_comapany_name' => 'Register Comapany Name',
            'address' => 'Address',
            'gst' => 'Gst',
            'logo' => 'Logo',
            'is_highlighted' => 'Is Highlighted',
            'google_rating' => 'Google Rating',
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
        $this->safarioperator_request_model->category_id                     =  $this->category_id;
        $this->safarioperator_request_model->safari_operator_id              =  $this->safari_operator_id;
        $this->safarioperator_request_model->business_name                   =  $this->business_name;
        $this->safarioperator_request_model->register_comapany_name          =  $this->register_comapany_name;
        $this->safarioperator_request_model->address                         =  $this->address;
        $this->safarioperator_request_model->gst                             =  $this->gst;
        $this->safarioperator_request_model->logo                            =  $this->logo;
        $this->safarioperator_request_model->is_highlighted                  =  $this->is_highlighted;
        $this->safarioperator_request_model->google_rating                   =  $this->google_rating;
        $this->safarioperator_request_model->google_review_count             =  $this->google_review_count;
        $this->safarioperator_request_model->google_business_url             =  $this->google_business_url;
        $this->safarioperator_request_model->google_business_name            =  $this->google_business_name;
        $this->safarioperator_request_model->about_business                  =  $this->about_business;
        $this->safarioperator_request_model->facebook_url                    =  $this->facebook_url;
        $this->safarioperator_request_model->instagram_url                   =  $this->instagram_url;
        $this->safarioperator_request_model->youtube_link                    =  $this->youtube_link;
        $this->safarioperator_request_model->phone_no                        =  $this->phone_no;
        $this->safarioperator_request_model->email                           =  $this->email;
        $this->safarioperator_request_model->website                         =  $this->website;
        $this->safarioperator_request_model->is_register_company             =  $this->is_register_company;
        $this->safarioperator_request_model->has_a_website                   =  $this->has_a_website;
        $this->safarioperator_request_model->offers_other_wildlifeactivities =  $this->offers_other_wildlifeactivities;
        $this->safarioperator_request_model->has_cancellation_policy         =  $this->has_cancellation_policy;
        $this->safarioperator_request_model->wildlife_photographer           =  $this->wildlife_photographer;
        $this->safarioperator_request_model->wildlife_influencer             =  $this->wildlife_influencer;
        $this->safarioperator_request_model->is_offer_premium_budget         =  $this->is_offer_premium_budget;
        $this->safarioperator_request_model->is_offer_standard_budget        =  $this->is_offer_standard_budget;
        $this->safarioperator_request_model->is_offer_economical_budget      =  $this->is_offer_economical_budget;
        $this->safarioperator_request_model->starting_price                  =  $this->starting_price;
        $this->safarioperator_request_model->is_approved                     =  $this->is_approved;
        $this->safarioperator_request_model->operator_name                   =  $this->operator_name;
        $this->safarioperator_request_model->operator_phone_no               =  $this->operator_phone_no;
        $this->safarioperator_request_model->operator_email                  =  $this->operator_email;
        $this->safarioperator_request_model->status                          =  $this->this->safarioperator_request_model->status;
    }
}
