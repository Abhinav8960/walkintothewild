<?php

namespace api\models\account\form;

use yii\base\Model;


class SafaritourRegistrationForm extends \frontend\models\registration\form\SafaritourRegistrationForm
{
    public function rules()
    {
        $rules = [
            [['category_id', 'safari_operator_id', 'is_highlighted', 'google_review_count', 'phone_no', 'is_register_company', 'has_a_website', 'has_cancellation_policy', 'wildlife_photographer', 'wildlife_influencer', 'is_offer_premium_budget', 'is_offer_standard_budget', 'is_offer_economical_budget', 'is_approved', 'status', 'account_type'], 'integer'],
            [['is_agree'], 'required', 'requiredValue' => 1, 'message' => 'You must agree to the terms and conditions.'],

            [['business_name', 'register_comapany_name', 'address', 'park_id', 'email', 'budget_segment'], 'required'],
            [['phone_no', 'operator_phone_no'], 'unique', 'targetClass' => 'frontend\models\registration\SafariOperatorRequest', 'message' => 'This phone has already been taken.', 'targetAttribute' => 'id'],
            [['phone_no', 'operator_phone_no'], 'match', 'pattern' => '/^[1234567890]\d{9}$/', 'message' => 'Invalid Phone number.'],
            [['facebook_url', 'instagram_url', 'youtube_link'], 'url'],
            [['operator_email', 'email'], 'email'],
            [['google_rating', 'starting_price'], 'number'],
            [['google_rating'], 'number', 'max' => 5],
            [['about_business'], 'string'],
            [['business_name', 'register_comapany_name', 'address', 'gst', 'google_business_url', 'google_business_name', 'facebook_url', 'instagram_url', 'youtube_link', 'email', 'website', 'operator_name', 'operator_phone_no', 'operator_email'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],
            [['is_highlighted', 'has_cancellation_policy', 'is_register_company', 'has_a_website', 'wildlife_photographer', 'wildlife_influencer', 'is_approved', 'starting_price', 'operator_name'], 'default', 'value' => 0],
            [['park_id', 'logo', 'budget_segment', 'offers_other_wildlifeactivities', 'user_id'], 'safe'],
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
        ];

        return $rules;
    }
}
