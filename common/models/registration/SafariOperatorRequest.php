<?php

namespace common\models\registration;

use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorActivities;
use common\models\operator\SafariOperatorPark;
use common\models\User;
use Yii;
use yii\helpers\FileHelper;

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
            [['safari_operator_id', 'is_highlighted', 'google_review_count', 'phone_no', 'is_register_company', 'has_a_website', 'has_cancellation_policy', 'wildlife_photographer', 'wildlife_influencer', 'is_offer_premium_budget', 'is_offer_standard_budget', 'is_offer_economical_budget', 'is_approved', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
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
            return '/storage/safarioperatorrequest/' . $this->id . '/' . $this->logo;
        }
    }


    /**
     * Parks List
     */
    public function getParkrequests()
    {
        return $this->hasMany(SafariOperatorRequestPark::className(), ['safari_operator_request_id' => 'id']);
    }

    public static function safariapproved(self $safarioperator_request_model)
    {
        $safari_operator = SafariOperator::find()->where(['id' => $safarioperator_request_model->safari_operator_id])->limit(1)->one();
        if (!$safari_operator) {
            $safari_operator = new SafariOperator();
        }
        $safari_operator->user_id                         =  $safarioperator_request_model->user_id;
        $safari_operator->category_id                     =  $safarioperator_request_model->category_id;
        $safari_operator->safari_operator_request_id      =  $safarioperator_request_model->id;
        $safari_operator->business_name                   =  $safarioperator_request_model->business_name;
        $safari_operator->register_comapany_name          =  $safarioperator_request_model->register_comapany_name;
        $safari_operator->address                         =  $safarioperator_request_model->address;
        $safari_operator->gst                             =  $safarioperator_request_model->gst;
        if ($safarioperator_request_model->logo <> '') {
            $safari_operator->logo                            =  $safarioperator_request_model->logo;
        }
        $safari_operator->is_highlighted                  =  $safarioperator_request_model->is_highlighted;
        $safari_operator->google_rating                   =  $safarioperator_request_model->google_rating;
        $safari_operator->google_review_count             =  $safarioperator_request_model->google_review_count;
        $safari_operator->google_business_url             =  $safarioperator_request_model->google_business_url;
        $safari_operator->google_business_name            =  $safarioperator_request_model->google_business_name;
        $safari_operator->about_business                  =  $safarioperator_request_model->about_business;
        $safari_operator->facebook_url                    =  $safarioperator_request_model->facebook_url;
        $safari_operator->instagram_url                   =  $safarioperator_request_model->instagram_url;
        $safari_operator->youtube_link                    =  $safarioperator_request_model->youtube_link;
        $safari_operator->phone_no                        =  $safarioperator_request_model->phone_no;
        $safari_operator->email                           =  $safarioperator_request_model->email;
        $safari_operator->website                         =  $safarioperator_request_model->website;
        $safari_operator->is_register_company             =  $safarioperator_request_model->is_register_company;
        $safari_operator->has_a_website                   =  $safarioperator_request_model->has_a_website;
        $safari_operator->has_cancellation_policy         =  $safarioperator_request_model->has_cancellation_policy;
        $safari_operator->wildlife_photographer           =  $safarioperator_request_model->wildlife_photographer;
        $safari_operator->wildlife_influencer             =  $safarioperator_request_model->wildlife_influencer;
        $safari_operator->is_offer_premium_budget         =  $safarioperator_request_model->is_offer_premium_budget;
        $safari_operator->is_offer_standard_budget        =  $safarioperator_request_model->is_offer_standard_budget;
        $safari_operator->is_offer_economical_budget      =  $safarioperator_request_model->is_offer_economical_budget;
        $safari_operator->starting_price                  =  $safarioperator_request_model->starting_price;
        $safari_operator->is_approved                     =  $safarioperator_request_model->is_approved;
        $safari_operator->operator_name                   =  $safarioperator_request_model->operator_name;
        $safari_operator->operator_phone_no               =  $safarioperator_request_model->operator_phone_no;
        $safari_operator->operator_email                  =  $safarioperator_request_model->operator_email;
        $safari_operator->is_highlighted                  =  $safarioperator_request_model->is_highlighted;
        $safari_operator->status                          =  $safarioperator_request_model->status;
        if ($safari_operator->save(false)) {
            if ($safarioperator_request_model->logo <> '') {
                $sourcePath = Yii::$app->params['datapath'] . '/safarioperatorrequest/' . $safari_operator->safari_operator_request_id . '/' . $safarioperator_request_model->logo;
                $destinationPath = Yii::$app->params['datapath'] . '/safarioperator/' . $safari_operator->id . '/' . $safarioperator_request_model->logo;
                $destinationDir = Yii::$app->params['datapath'] . '/safarioperator/' . $safari_operator->id . '/';
                if (!file_exists($destinationDir)) {
                    FileHelper::createDirectory($destinationDir);
                }

                if (file_exists($sourcePath)) {
                    copy($sourcePath, $destinationPath);
                }
            }

            $parks = SafariOperatorRequestPark::find()->where(['safari_operator_request_id' => $safarioperator_request_model->id, 'status' => 1])->all();

            if ($parks) {
                SafariOperatorPark::updateAll(['status' => 2], ['safari_operator_id' => $safari_operator->id]);
                foreach ($parks as $park) {
                    $safarioperatorpark = new SafariOperatorPark();
                    $safarioperatorpark->safari_operator_id = $safari_operator->id;
                    $safarioperatorpark->park_id = $park->park_id;
                    $safarioperatorpark->save(false);
                }
            }

            $activities = SafariOperatorRequestActivities::find()->where(['safari_operator_request_id' => $safarioperator_request_model->id, 'status' => 1])->all();
            if ($activities) {
                SafariOperatorActivities::updateAll(['status' => 2], ['safari_operator_id' => $safari_operator->id]);
                foreach ($activities as $activity) {
                    $safarioperatorrequestactivities = new SafariOperatorActivities();
                    $safarioperatorrequestactivities->safari_operator_id = $safari_operator->id;
                    $safarioperatorrequestactivities->wildlife_activity_id = $activity->wildlife_activity_id;
                    $safarioperatorrequestactivities->save(false);
                }
            }

            if ($safari_operator) {
                if ($safari_operator->user_id) {
                    $user = User::find()->where(['id' => $safari_operator->user_id])->limit(1)->one();
                } elseif ($safari_operator->email) {
                    $user = User::find()->where(['email' => $safari_operator->email])->limit(1)->one();
                }
                if ($user) {
                    $user->is_safari_operator = 1;
                    $user->status = 10;

                    if ($user->save(false)) {
                        $safari_operator->user_id = $user->id;
                        $safari_operator->save(false);
                        if ($user->save(false)) {
                            \Yii::$app->session->setFlash('success', 'Operator Approved Successfully');
                            return $safari_operator;
                        }
                    }
                }
            }
        }
    }
}
