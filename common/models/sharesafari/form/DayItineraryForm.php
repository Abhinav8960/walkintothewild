<?php

namespace common\models\sharesafari\form;

use common\models\partnergallery\PartnerGallery;
use common\models\sharesafari\ShareSafariDay;
use common\models\sharesafari\ShareSafariIncluded;
use Yii;


class DayItineraryForm  extends \yii\base\Model

{
    public $share_safari_id;
    public $version;
    public $no_of_day;
    public $day;
    public $day_title;
    public $meal_breakfast;
    public $meal_lunch;
    public $meal_dinner;
    public $start_location;
    public $end_location;
    public $day_description;
    public $day_activity;
    public $day_accommodation;
    public $day_note;
    public $hotel_name;
    public $day_image;
    public $latitude;
    public $longitude;
    public $share_safari_day_model;
    public $status;

    public $partner_gallery_id;
    public $gallery_json;
    public $gallery_version;


    /**
     * @param [type] $share_safari_day_model
     */
    public function __construct(?ShareSafariDay $share_safari_day_model = null)
    {
        $this->share_safari_day_model = Yii::createObject([
            'class' => ShareSafariDay::class
        ]);
        if ($share_safari_day_model != null) {
            $this->share_safari_day_model = $share_safari_day_model;
            $this->share_safari_id = $this->share_safari_day_model->share_safari_id;
            $this->version = $this->share_safari_day_model->version;
            $this->day = $this->share_safari_day_model->day;
            $this->day_title = $this->share_safari_day_model->day_title;
            $this->meal_breakfast = $this->share_safari_day_model->meal_breakfast;
            $this->meal_lunch = $this->share_safari_day_model->meal_lunch;
            $this->meal_dinner = $this->share_safari_day_model->meal_dinner;
            $this->start_location = $this->share_safari_day_model->start_location;
            $this->end_location = $this->share_safari_day_model->end_location;
            $this->day_description = $this->share_safari_day_model->day_description;
            $this->day_activity = $this->share_safari_day_model->day_activity;
            $this->day_accommodation = $this->share_safari_day_model->day_accommodation;
            $this->day_note = $this->share_safari_day_model->day_note;
            $this->hotel_name = $this->share_safari_day_model->hotel_name;
            $this->day_image = $this->share_safari_day_model->day_image;
            $this->latitude = $this->share_safari_day_model->latitude;
            $this->longitude = $this->share_safari_day_model->longitude;
            $this->status = $this->share_safari_day_model->status;

            $this->partner_gallery_id = $this->share_safari_day_model->partner_gallery_id;
            $this->gallery_json = $this->share_safari_day_model->gallery_json;
            $this->gallery_version = $this->share_safari_day_model->gallery_version;
        }
    }

    public function rules()
    {
        return [
            [['share_safari_id', 'day', 'day_title', 'version'], 'required'],
            [['status'], 'default', 'value' => 1],
            [['meal_breakfast', 'meal_lunch', 'meal_dinner'], 'default', 'value' => 0],
            [['day', 'meal_breakfast', 'meal_lunch', 'meal_dinner'], 'integer'],
            [[
                'day_description',
                'day_activity',
                'day_accommodation',
                'day_note',
                'start_location',
                'end_location',
                'hotel_name',
                'day_image',
                'latitude',
                'longitude'
            ], 'safe'],


            [
                ['day_image'],
                'image',
                'extensions' => ['jpeg', 'jpg', 'png'],
                'minWidth' => 940,
                'maxWidth' => 940,
                'maxHeight' => 430,
                'minHeight' => 430,
                'maxSize' => 250 * 1024,
                'skipOnEmpty' => true,
            ],
            [['day_description'], 'string', 'max' => 2000],
            [['partner_gallery_id','gallery_version'], 'integer'],
            [['gallery_json'], 'safe'],
            [['day_title'],'string', 'max' => 100]
            
        ];
    }

    /**
     * Initialize Form Model
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->share_safari_day_model->share_safari_id = $this->share_safari_id;
        $this->share_safari_day_model->version = $this->version;
        $this->share_safari_day_model->day = $this->day;
        $this->share_safari_day_model->day_title = $this->day_title;
        if ($this->share_safari_id) {
            $sharesafari_includes = ShareSafariIncluded::find()->where(['share_safari_id' => $this->share_safari_id, 'include_id' => 2, 'selection' => 1, 'status' => 1])->limit(1)->one();
            if ($sharesafari_includes) {
                $this->share_safari_day_model->meal_breakfast = 1;
                $this->share_safari_day_model->meal_lunch = 1;
                $this->share_safari_day_model->meal_dinner = 1;
            }
        }
        $this->share_safari_day_model->day_description = $this->day_description;
        $this->share_safari_day_model->day_activity = $this->day_activity;
        $this->share_safari_day_model->day_accommodation = $this->day_accommodation;
        $this->share_safari_day_model->day_note = $this->day_note;
        $this->share_safari_day_model->start_location = $this->start_location;
        $this->share_safari_day_model->end_location = $this->end_location;
        $this->share_safari_day_model->hotel_name = $this->hotel_name;
        $this->share_safari_day_model->latitude = $this->latitude;
        $this->share_safari_day_model->longitude = $this->longitude;
        $this->share_safari_day_model->status = $this->status;

        $this->share_safari_day_model->partner_gallery_id = $this->partner_gallery_id;
        if ($this->partner_gallery_id) {
            $live = PartnerGallery::find()->where(['id' => $this->partner_gallery_id])->limit(1)->one();
            $this->share_safari_day_model->gallery_json = $live->live_images;
            if (!empty($live->version)) {
                $this->share_safari_day_model->gallery_version = $live->version;
            }
        }
    }


    /**
     * Upload Day image
     *
     * @return void
     */
    // public function UploadFile()
    // {
    //     if ($this->day_image) {
    //         $storagePath = Yii::$app->params['datapath'] . '/share_safari/day';

    //         if (!file_exists($storagePath)) {
    //             mkdir($storagePath);
    //             chmod($storagePath, 0777);
    //         }
    //         $storagePath = $storagePath . '/' . $this->share_safari_day_model->id;
    //         if (!file_exists($storagePath)) {
    //             mkdir($storagePath);
    //             chmod($storagePath, 0777);
    //         }

    //         $fileName = 'sharesafari_day' . '-' . time() . '.' . $this->day_image->extension;
    //         $filePath = $storagePath . '/' . $fileName;

    //         if ($this->day_image->saveAs($filePath)) {
    //             $this->share_safari_day_model->day_image = $fileName;
    //             $this->share_safari_day_model->save(false);
    //         }
    //     }
    // }
}
