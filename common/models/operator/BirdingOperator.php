<?php

namespace common\models\operator;

use Yii;

/**
 * This is the model class for table "birding_operator".
 *
 * @property int $id
 * @property int|null $birding_operator_request_id
 * @property int|null $category_id
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
 * @property int $has_cancellation_policy
 * @property int $wildlife_photographer
 * @property int $wildlife_influencer
 * @property int $is_offer_premium_budget
 * @property int $is_offer_standard_budget
 * @property int $is_offer_economical_budget
 * @property int $is_wildlife_trekking
 * @property int $is_wildlife_non_safari_drive
 * @property int $is_bird_watching
 * @property int $is_camping
 * @property float $starting_price
 * @property int $is_approved
 * @property int|null $user_id
 * @property string $operator_name
 * @property string $operator_phone_no
 * @property string $operator_email
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class BirdingOperator extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'birding_operator';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['birding_operator_request_id', 'category_id', 'is_highlighted', 'google_review_count', 'phone_no', 'is_register_company', 'has_a_website', 'has_cancellation_policy', 'wildlife_photographer', 'wildlife_influencer', 'is_offer_premium_budget', 'is_offer_standard_budget', 'is_offer_economical_budget', 'is_wildlife_trekking', 'is_wildlife_non_safari_drive', 'is_bird_watching', 'is_camping', 'is_approved', 'user_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['business_name', 'phone_no', 'operator_name', 'operator_phone_no', 'operator_email'], 'required'],
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
            'birding_operator_request_id' => 'Safari Operator Request ID',
            'category_id' => 'Category ID',
            'business_name' => 'Business Name',
            'register_comapany_name' => 'Register Comapany Name',
            'address' => 'Address',
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
            'has_cancellation_policy' => 'Has Cancellation Policy',
            'wildlife_photographer' => 'Wildlife Photographer',
            'wildlife_influencer' => 'Wildlife Influencer',
            'is_offer_premium_budget' => 'Is Offer Premium Budget',
            'is_offer_standard_budget' => 'Is Offer Standard Budget',
            'is_offer_economical_budget' => 'Is Offer Economical Budget',
            'is_wildlife_trekking' => 'Is Wildlife Trekking',
            'is_wildlife_non_safari_drive' => 'Is Wildlife Non Safari Drive',
            'is_bird_watching' => 'Is Bird Watching',
            'is_camping' => 'Is Camping',
            'starting_price' => 'Starting Price',
            'is_approved' => 'Is Approved',
            'user_id' => 'User ID',
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
}
