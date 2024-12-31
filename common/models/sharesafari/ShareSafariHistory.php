<?php

namespace common\models\sharesafari;

use common\models\park\SafariPark;
use common\models\User;
use Yii;

/**
 * This is the model class for table "share_safari_history".
 *
 * @property int $id
 * @property string $share_safari_title
 * @property int|null $type
 * @property int|null $share_safari_request_id
 * @property string $slug
 * @property int $host_user_id
 * @property int|null $host_type
 * @property int|null $park_id
 * @property int|null $share_safari_agenda_id
 * @property int|null $no_of_safari
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $cut_off_date
 * @property string|null $image
 * @property int|null $stay_category_id
 * @property int|null $estimate_price_min
 * @property int|null $estimate_price_max
 * @property int|null $cost_per_person
 * @property string|null $safari_plan
 * @property string|null $website_url
 * @property int|null $total_seat
 * @property int|null $share_seat
 * @property int|null $tour_duration
 * @property string|null $share_safari_inclusion
 * @property string|null $share_safari_exclusion
 * @property string|null $share_safari_terms_condtition
 * @property string|null $privacy_policy
 * @property string|null $change_policy
 * @property string|null $what_you_must_carry
 * @property string|null $date_change_policy
 * @property string|null $refund_policy
 * @property string|null $getting_there
 * @property int $breakfast_included
 * @property int $lunch_included
 * @property int $dinner_included
 * @property int $meal_not_included
 * @property int|null $mail_sent
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $delete_reason_id
 * @property string|null $delete_reason
 * @property int|null $status
 * @property int $total_view
 */
class ShareSafariHistory extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'share_safari_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'share_safari_request_id', 'host_user_id', 'host_type', 'park_id', 'share_safari_agenda_id', 'no_of_safari', 'stay_category_id', 'estimate_price_min', 'estimate_price_max', 'cost_per_person', 'total_seat', 'share_seat', 'tour_duration', 'breakfast_included', 'lunch_included', 'dinner_included', 'meal_not_included', 'mail_sent', 'created_at', 'created_by', 'updated_at', 'updated_by', 'delete_reason_id', 'status', 'total_view'], 'integer'],
            [['start_date', 'end_date', 'cut_off_date'], 'safe'],
            [['safari_plan', 'website_url', 'share_safari_inclusion', 'share_safari_exclusion', 'share_safari_terms_condtition', 'privacy_policy', 'change_policy', 'what_you_must_carry', 'date_change_policy', 'refund_policy', 'getting_there', 'delete_reason'], 'string'],
            [['share_safari_title'], 'string', 'max' => 255],
            [['slug', 'image'], 'string', 'max' => 512],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'share_safari_title' => 'Share Safari Title',
            'type' => 'Type',
            'share_safari_request_id' => 'Share Safari Request ID',
            'slug' => 'Slug',
            'host_user_id' => 'Host User ID',
            'host_type' => 'Host Type',
            'park_id' => 'Park ID',
            'share_safari_agenda_id' => 'Share Safari Agenda ID',
            'no_of_safari' => 'No Of Safari',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'cut_off_date' => 'Cut Off Date',
            'image' => 'Image',
            'stay_category_id' => 'Stay Category ID',
            'estimate_price_min' => 'Estimate Price Min',
            'estimate_price_max' => 'Estimate Price Max',
            'cost_per_person' => 'Cost Per Person',
            'safari_plan' => 'Safari Plan',
            'website_url' => 'Website Url',
            'total_seat' => 'Total Seat',
            'share_seat' => 'Share Seat',
            'tour_duration' => 'Tour Duration',
            'share_safari_inclusion' => 'Share Safari Inclusion',
            'share_safari_exclusion' => 'Share Safari Exclusion',
            'share_safari_terms_condtition' => 'Share Safari Terms Condtition',
            'privacy_policy' => 'Privacy Policy',
            'change_policy' => 'Change Policy',
            'what_you_must_carry' => 'What You Must Carry',
            'date_change_policy' => 'Date Change Policy',
            'refund_policy' => 'Refund Policy',
            'getting_there' => 'Getting There',
            'breakfast_included' => 'Breakfast Included',
            'lunch_included' => 'Lunch Included',
            'dinner_included' => 'Dinner Included',
            'meal_not_included' => 'Meal Not Included',
            'mail_sent' => 'Mail Sent',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'delete_reason_id' => 'Delete Reason ID',
            'delete_reason' => 'Delete Reason',
            'status' => 'Status',
            'total_view' => 'Total View',
        ];
    }

    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'host_user_id']);
    }
}
