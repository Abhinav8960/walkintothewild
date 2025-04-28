<?php

namespace common\models\package\form;

use Yii;
use common\models\package\PackageVersion;
use common\models\package\PackageDay;
use common\models\package\PackageFeature;
use common\models\package\PackageIncluded;
use common\models\package\PackageSafariPark;


class DayItineraryForm  extends \yii\base\Model

{
    public $package_id;
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
    public $package_day_model;
    public $status;


    /**
     * @param [type] $package_day_model
     */
    public function __construct(PackageDay $package_day_model = null)
    {
        $this->package_day_model = Yii::createObject([
            'class' => PackageDay::className()
        ]);
        if ($package_day_model != null) {
            $this->package_day_model = $package_day_model;
            $this->package_id = $this->package_day_model->package_id;
            $this->version = $this->package_day_model->version;
            $this->day = $this->package_day_model->day;
            $this->day_title = $this->package_day_model->day_title;
            $this->meal_breakfast = $this->package_day_model->meal_breakfast;
            $this->meal_lunch = $this->package_day_model->meal_lunch;
            $this->meal_dinner = $this->package_day_model->meal_dinner;
            $this->start_location = $this->package_day_model->start_location;
            $this->end_location = $this->package_day_model->end_location;
            $this->day_description = $this->package_day_model->day_description;
            $this->day_activity = $this->package_day_model->day_activity;
            $this->day_accommodation = $this->package_day_model->day_accommodation;
            $this->day_note = $this->package_day_model->day_note;
            $this->hotel_name = $this->package_day_model->hotel_name;
            $this->day_image = $this->package_day_model->day_image;
            $this->latitude = $this->package_day_model->latitude;
            $this->longitude = $this->package_day_model->longitude;
            $this->status = $this->package_day_model->status;
        }
    }

    public function rules()
    {
        return [
            [['package_id', 'version', 'day', 'day_title'], 'required'],
            [['status'], 'default', 'value' => 1],
            [['meal_breakfast', 'meal_lunch', 'meal_dinner'], 'default', 'value' => 0],
            [['day', 'meal_breakfast', 'meal_lunch', 'meal_dinner'], 'integer'],
            [[
                'day_description',
                'day_activity',
                'day_accommodation',
                'day_note',
                'day_title',
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
        ];
    }

    /**
     * Initialize Form Model
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->package_day_model->package_id = $this->package_id;
        $this->package_day_model->version = $this->version;
        $this->package_day_model->day = $this->day;
        $this->package_day_model->day_title = $this->day_title;
        if ($this->package_id) {
            $package_includes = PackageIncluded::find()->where(['package_id' => $this->package_id, 'version' => $this->version, 'include_id' => 2, 'selection' => 1, 'status' => PackageIncluded::STATUS_ACTIVE])->limit(1)->one();
            if ($package_includes) {
                $this->package_day_model->meal_breakfast = 1;
                $this->package_day_model->meal_lunch = 1;
                $this->package_day_model->meal_dinner = 1;
            }
        }
        $this->package_day_model->day_description = $this->day_description;
        $this->package_day_model->day_activity = $this->day_activity;
        $this->package_day_model->day_accommodation = $this->day_accommodation;
        $this->package_day_model->day_note = $this->day_note;
        $this->package_day_model->start_location = $this->start_location;
        $this->package_day_model->end_location = $this->end_location;
        $this->package_day_model->hotel_name = $this->hotel_name;
        $this->package_day_model->latitude = $this->latitude;
        $this->package_day_model->longitude = $this->longitude;
        $this->package_day_model->status = $this->status;
    }


    /**
     * Upload Day image
     *
     * @return void
     */
    public function UploadFile()
    {
        if ($this->day_image) {
            $storagePath = Yii::$app->params['datapath'] . '/package/day';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->package_day_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'package_day' . '-' . time() . '.' . $this->day_image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->day_image->saveAs($filePath)) {
                $this->package_day_model->day_image = $fileName;
                $this->package_day_model->save(false);
            }
        }
    }
}
