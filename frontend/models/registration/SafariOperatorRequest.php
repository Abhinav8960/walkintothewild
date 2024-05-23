<?php

namespace frontend\models\registration;

use Yii;

/**
 * This is the model class for table "safari_operator_request".
 *
 * @property int $id
 * @property int|null $safari_operator_id
 * @property string $business_name
 * @property string|null $register_comapany_name
 * @property string|null $address
 * @property string|null $gst
 * @property string|null $logo
 * @property int $is_highlighted
 * @property float|null $google_rating
 * @property int|null $google_review_count
 * @property string|null $google_business_url
 * @property string|null $google_business_name
 * @property string|null $about_business
 * @property string|null $facebook_url
 * @property string|null $instagram_url
 * @property string|null $youtube_link
 * @property int $phone_no
 * @property string|null $email
 * @property string|null $website
 * @property int $is_register_company
 * @property int $has_a_website
 * @property int $offers_other_wildlifeactivities
 * @property int $has_cancellation_policy
 * @property int $wildlife_photographer
 * @property int $wildlife_influencer
 * @property int $is_offer_premium_budget
 * @property int $is_offer_standard_budget
 * @property int $is_offer_economical_budget
 * @property float $starting_price
 * @property int $is_approved
 * @property string $operator_name
 * @property string $operator_phone_no
 * @property string $operator_email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class SafariOperatorRequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'safari_operator_request';
    }




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
    public function rules()
    {
        return [
            [['safari_operator_id', 'is_highlighted', 'google_review_count', 'phone_no', 'is_register_company', 'has_a_website', 'offers_other_wildlifeactivities', 'has_cancellation_policy', 'wildlife_photographer', 'wildlife_influencer', 'is_offer_premium_budget', 'is_offer_standard_budget', 'is_offer_economical_budget', 'is_approved', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['business_name', 'phone_no', 'operator_name', 'operator_phone_no', 'operator_email', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'required'],
            [['google_rating', 'starting_price'], 'number'],
            [['about_business'], 'string'],
            [['business_name', 'register_comapany_name', 'address', 'gst', 'logo', 'google_business_url', 'google_business_name', 'facebook_url', 'instagram_url', 'youtube_link', 'email', 'website', 'operator_name', 'operator_phone_no', 'operator_email'], 'string', 'max' => 255],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }



    public function getImagepath()
    {
        if ($this->logo != '') {
            return '/storage/safarioperator/' . $this->id . '/' . $this->logo;
        }
    }
}
