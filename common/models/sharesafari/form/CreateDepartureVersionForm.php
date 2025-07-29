<?php

namespace common\models\sharesafari\form;

use common\models\partnergallery\PartnerGallery;
use Yii;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariParklist;
use common\models\sharesafari\ShareSafariVersion;
class CreateDepartureVersionForm extends \yii\base\Model
{
    public $share_safari_id;
    public $version;

    public $type;
    public $share_safari_title;
    public $host_user_id;
    public $host_type;
    public $park_list;
    public $park_id;
    public $share_safari_agenda_id;
    public $no_of_safari;
    public $start_date;
    public $end_date;
    public $stay_category_id;
    public $cost_per_person;
    public $safari_plan;
    public $total_seat;
    public $share_seat;
    public $tour_duration;
    public $status;
    public $share_safari_inclusion;
    public $share_safari_exclusion;
    public $share_safari_included;
    public $share_safari_terms_condtition;
    public $privacy_policy;
    public $change_policy;
    public $what_you_must_carry;
    public $date_change_policy;
    public $refund_policy;
    public $getting_there;
    public $rand_text;
    public $cut_off_date;

    public $breakfast_included;
    public $lunch_included;
    public $dinner_included;
    public $meal_not_included;
    public $mail_sent;

    public $action_url;
    public $action_validate_url;

    public $partner_gallery_id;
    public $gallery_json;
    public $image;
    public $image_filepath;
    public $created_at;

    public $shared_safari_departure_version_model;

    public function __construct(ShareSafariVersion $shared_safari_departure_version_model = null)
    {
        $this->shared_safari_departure_version_model = Yii::createObject([
            'class' => ShareSafariVersion::class
        ]);

        $this->version = '1';
        if ($shared_safari_departure_version_model  != '') {
            $this->shared_safari_departure_version_model = $shared_safari_departure_version_model;

            $this->share_safari_id = $this->shared_safari_departure_version_model->share_safari_id;
            $this->version = $this->shared_safari_departure_version_model->version;

            $this->type =  $this->shared_safari_departure_version_model->type;
            $this->share_safari_title =  $this->shared_safari_departure_version_model->share_safari_title;
            $this->host_user_id =  $this->shared_safari_departure_version_model->host_user_id;
            $this->host_type =  $this->shared_safari_departure_version_model->host_type;

            $this->share_safari_agenda_id =  $this->shared_safari_departure_version_model->share_safari_agenda_id;
            $this->no_of_safari =  $this->shared_safari_departure_version_model->no_of_safari;
            $this->start_date =  $this->shared_safari_departure_version_model->start_date;
            $this->end_date =  $this->shared_safari_departure_version_model->end_date;
            $this->cut_off_date =  $this->shared_safari_departure_version_model->cut_off_date;
            $this->stay_category_id =  $this->shared_safari_departure_version_model->stay_category_id;
            $this->cost_per_person =  $this->shared_safari_departure_version_model->cost_per_person;
            $this->safari_plan =  $this->shared_safari_departure_version_model->safari_plan;
            $this->total_seat =  $this->shared_safari_departure_version_model->total_seat;
            $this->share_seat =  $this->shared_safari_departure_version_model->share_seat;
            $this->tour_duration =  $this->shared_safari_departure_version_model->tour_duration;
            $this->status =  $this->shared_safari_departure_version_model->status;

            $this->share_safari_inclusion = $this->shared_safari_departure_version_model->share_safari_inclusion;
            $this->share_safari_exclusion = $this->shared_safari_departure_version_model->share_safari_exclusion;
            $this->share_safari_terms_condtition = $this->shared_safari_departure_version_model->share_safari_terms_condtition;
            $this->privacy_policy = $this->shared_safari_departure_version_model->privacy_policy;
            $this->change_policy = $this->shared_safari_departure_version_model->change_policy;
            $this->what_you_must_carry = $this->shared_safari_departure_version_model->what_you_must_carry;
            $this->date_change_policy = $this->shared_safari_departure_version_model->date_change_policy;
            $this->refund_policy = $this->shared_safari_departure_version_model->refund_policy;
            $this->getting_there = $this->shared_safari_departure_version_model->getting_there;

            $this->breakfast_included = $this->shared_safari_departure_version_model->breakfast_included;
            $this->lunch_included = $this->shared_safari_departure_version_model->lunch_included;
            $this->dinner_included = $this->shared_safari_departure_version_model->dinner_included;
            $this->meal_not_included = $this->shared_safari_departure_version_model->meal_not_included;

            $this->image_filepath = $this->shared_safari_departure_version_model->image_filepath;
            $this->created_at = $this->shared_safari_departure_version_model->created_at;
            $this->partner_gallery_id = $this->shared_safari_departure_version_model->partner_gallery_id;

            $this->park_list =  ShareSafariParklist::find()->select('park_id')->where(['share_safari_id' => $this->shared_safari_departure_version_model->share_safari_id, 'version' => $this->shared_safari_departure_version_model->version])->column(); //abb multiple park ko store karenge
        }
    }

    public function rules()
    {
        return [
            [['share_safari_title', 'host_type', 'park_list', 'share_safari_agenda_id', 'no_of_safari', 'cost_per_person', 'total_seat', 'share_seat', 'start_date', 'end_date', 'safari_plan'], 'required', 'message' => '{attribute}:Required'],
            [['host_user_id', 'host_type', 'park_id', 'share_safari_agenda_id', 'no_of_safari', 'stay_category_id', 'cost_per_person', 'total_seat', 'share_seat', 'tour_duration', 'status', 'type'], 'integer'],
            [['start_date', 'end_date', 'park_list', 'rand_text'], 'safe'],
            [['share_safari_title'], 'string', 'max' => 255],
            [['safari_plan'], 'string'],
            ['end_date', 'compare', 'compareAttribute' => 'start_date', 'operator' => '>'],
            [['safari_plan'], 'validateContent'],
            [['no_of_safari', 'total_seat', 'share_seat'], 'integer', 'max' => 100],
            ['cost_per_person', 'integer', 'max' => 1000000],
            ['cut_off_date', 'compare', 'compareAttribute' => 'start_date', 'operator' => '<'],
            [['breakfast_included', 'lunch_included', 'dinner_included', 'meal_not_included'], 'safe'],
            [['breakfast_included', 'lunch_included', 'dinner_included', 'meal_not_included', 'mail_sent'], 'default', 'value' => 0],
            ['share_seat', 'compare', 'compareAttribute' => 'total_seat', 'operator' => '<=', 'message' => "Available Seat must be less than or equal to Total Seat"],
            [['share_safari_id', 'version'], 'integer'],
            [['partner_gallery_id'], 'integer'],
            [['gallery_json'], 'safe'],
            [['image'], 'image', 'extensions' => ['png', 'jpeg', 'jpg'],],
            [['image_filepath'], 'string'],


        ];
    }

    public function validateMaxWords($attribute, $params)
    {
        $maxWords = $params['max'];
        $wordCount = str_word_count($this->$attribute);
        if ($wordCount > $maxWords) {
            $this->addError($attribute, "The $attribute must not exceed $maxWords words.");
        }
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['inclusion'] = ['share_safari_inclusion', 'share_safari_exclusion', 'share_safari_included', 'breakfast_included', 'lunch_included', 'dinner_included', 'meal_not_included'];
        $scenarios['policy_info'] = ['share_safari_terms_condtition', 'privacy_policy', 'change_policy', 'what_you_must_carry', 'date_change_policy', 'refund_policy', 'breakfast_included', 'lunch_included', 'dinner_included', 'meal_not_included'];
        $scenarios['getting_there'] = ['getting_there', 'breakfast_included', 'lunch_included', 'dinner_included', 'meal_not_included'];
        return $scenarios;
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'host_user_id' => 'Host User ID',
            'host_type' => 'Host Type',
            'park_id' => 'Park ID',
            'share_safari_agenda_id' => 'Share Safari Agenda ID',
            'no_of_safari' => 'No Of Safari',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'stay_category_id' => 'Accommodation',
            'cost_per_person' => 'Cost Per Person',
            'tour_duration' => 'Total Duration',
            'safari_plan' => 'Safari Plan',
            'total_seat' => 'Total Seat',
            'partner_gallery_id' => 'Gallery Id',
            'gallery_json' => 'Gallery Json',
            'image_filepath' => 'Image FilePath',
            'status' => 'Status',
        ];
    }

    private function getShareSafariId()
    {
        $m = new ShareSafari();
        $m->share_safari_title = $this->share_safari_title;
        $m->slug = ShareSafari::generateUnqiueSlug($this->share_safari_title);
        $m->host_user_id = $this->host_user_id;
        $m->status = 0;
        $m->save(false);
        return $m->id;
    }

    /**
     * Initialize Form Model
     *
     * @return void
     */
    public function initializeForm()
    {

        if ($this->share_safari_id == null) {
            $this->share_safari_id = $this->getShareSafariId();
        }
        $this->shared_safari_departure_version_model->share_safari_id = $this->share_safari_id;
        $this->shared_safari_departure_version_model->version = $this->version;
        $this->shared_safari_departure_version_model->type = $this->type;
        $this->shared_safari_departure_version_model->host_user_id = $this->host_user_id;
        $this->shared_safari_departure_version_model->share_safari_title = $this->share_safari_title;
        $this->shared_safari_departure_version_model->host_type = $this->host_type; // iss bhi check karna ha
        $this->shared_safari_departure_version_model->type = $this->type;
        $this->shared_safari_departure_version_model->share_safari_agenda_id = $this->share_safari_agenda_id;
        $this->shared_safari_departure_version_model->no_of_safari = $this->no_of_safari;
        $this->shared_safari_departure_version_model->start_date = $this->start_date;
        $this->shared_safari_departure_version_model->end_date = $this->end_date;
        $this->shared_safari_departure_version_model->cut_off_date = $this->cut_off_date;
        $this->shared_safari_departure_version_model->stay_category_id = $this->stay_category_id;
        $this->shared_safari_departure_version_model->cost_per_person = $this->cost_per_person;
        $this->shared_safari_departure_version_model->safari_plan = $this->safari_plan;
        $this->shared_safari_departure_version_model->total_seat = $this->total_seat;

        if ($this->status == ShareSafari::STATUS_FULL_SEAT) {
            $this->shared_safari_departure_version_model->share_seat = 0;
        } else {
            $this->shared_safari_departure_version_model->share_seat = $this->share_seat;
        }

        $this->shared_safari_departure_version_model->tour_duration = abs((round(strtotime($this->end_date) - strtotime($this->start_date)) / (60 * 60 * 24))) + 1;
        $this->shared_safari_departure_version_model->status = $this->status;


        $this->shared_safari_departure_version_model->share_safari_inclusion = $this->share_safari_inclusion;
        $this->shared_safari_departure_version_model->share_safari_exclusion = $this->share_safari_exclusion;
        $this->shared_safari_departure_version_model->share_safari_terms_condtition = $this->share_safari_terms_condtition;
        $this->shared_safari_departure_version_model->privacy_policy = $this->privacy_policy;
        $this->shared_safari_departure_version_model->change_policy = $this->change_policy;
        $this->shared_safari_departure_version_model->what_you_must_carry = $this->what_you_must_carry;
        $this->shared_safari_departure_version_model->date_change_policy = $this->date_change_policy;
        $this->shared_safari_departure_version_model->refund_policy = $this->refund_policy;
        $this->shared_safari_departure_version_model->getting_there = $this->getting_there;


        $this->shared_safari_departure_version_model->breakfast_included = $this->breakfast_included;
        $this->shared_safari_departure_version_model->lunch_included = $this->lunch_included;
        $this->shared_safari_departure_version_model->dinner_included = $this->dinner_included;
        $this->shared_safari_departure_version_model->meal_not_included = $this->meal_not_included;

        if ($this->park_list) {
            $this->shared_safari_departure_version_model->park_id = $this->park_list[0];
        }

        $this->shared_safari_departure_version_model->partner_gallery_id = $this->partner_gallery_id;
        if ($this->partner_gallery_id) {
            $live = PartnerGallery::find()->where(['id' => $this->partner_gallery_id, 'status' => PartnerGallery::STATUS_ACTIVE])->limit(1)->one();
            $this->shared_safari_departure_version_model->gallery_json = $live->live_images;
        }
    }


    public function validateContent($attribute, $params)
    {
        $wordCount = str_word_count($this->$attribute);
        if ($wordCount >= 1000) {
            $this->addError($attribute, 'Please provide content within 1000 words.');
        }
    }


    public function UploadFile()
    {
        if ($this->image) {
            $storagePath = 'fixed_departure' . '/' . date('ym', $this->created_at);
            $fileName =  $this->version . '_fixed_departure_image' . '_' . time() . '.' . $this->image->extension;
            $filePath = $storagePath . '/' . $fileName;
            if ($fileName) {
                if ($etag =  \common\Helper\FsHelper::saveUploadedFile($this->image, $filePath, $fileName, true)) {
                    $this->shared_safari_departure_version_model->image_filepath = $filePath;
                    $this->shared_safari_departure_version_model->save(false);
                }
            }
        }
    }
}
