<?php

namespace common\models\package\form;

use Yii;
use common\models\package\Package;
use common\models\package\PackageFeature;
use common\models\package\PackageIncluded;
use common\models\package\PackageSafariPark;

class PackageForm extends \yii\base\Model
{
    public $package_name;
    public $package_slug;
    public $no_of_day;
    public $no_of_night;
    public $no_of_safari;
    public $start_location;
    public $end_location;
    public $package_image;
    public $stay_category_id;
    public $cost_per_person;
    public $package_description;
    public $package_inclusion;
    public $package_exclusion;
    public $package_terms_condtition;
    public $privacy_policy;
    public $change_policy;
    public $what_you_must_carry;
    public $status;
    public $package_feature;
    public $package_included;
    public $package_park;
    public $package_model;
    public $action_url;
    public $action_validate_url;


    /**
     * @param [type] $package_model
     */
    public function __construct(Package $package_model = null)
    {
        $this->package_model = Yii::createObject([
            'class' => Package::className()
        ]);
        if ($package_model != null) {
            $this->package_model = $package_model;
            $this->package_name = $this->package_model->package_name;
            $this->package_image = $this->package_model->package_image;
            $this->package_slug = $this->package_model->package_slug;
            $this->no_of_day = $this->package_model->no_of_day;
            $this->no_of_night = $this->package_model->no_of_night;
            $this->no_of_safari = $this->package_model->no_of_safari;
            $this->start_location = $this->package_model->start_location;
            $this->end_location = $this->package_model->end_location;
            $this->stay_category_id = $this->package_model->stay_category_id;
            $this->cost_per_person = $this->package_model->cost_per_person;
            $this->package_description = $this->package_model->package_description;
            $this->package_inclusion = $this->package_model->package_inclusion;
            $this->package_exclusion = $this->package_model->package_exclusion;
            $this->package_terms_condtition = $this->package_model->package_terms_condtition;
            $this->privacy_policy = $this->package_model->privacy_policy;
            $this->change_policy = $this->package_model->change_policy;
            $this->what_you_must_carry = $this->package_model->what_you_must_carry;
            $this->status = $this->package_model->status;

            $this->package_feature = PackageFeature::find()->select('feature_id')->where(['package_id' => $this->package_model->id, 'status' => 1])->column();
            $this->package_included = PackageIncluded::find()->select('include_id', 'selection')->where(['package_id' => $this->package_model->id, 'status' => 1])->column();
            $this->package_park = PackageSafariPark::find()->select('park_id')->where(['package_id' => $this->package_model->id, 'status' => 1])->column();
        }
    }

    public function rules()
    {
        return [
            [
                ['package_image'], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
                'minWidth' => 940,
                'maxWidth' => 940,
                'maxHeight' => 430,
                'minHeight' => 430,
                'maxSize' => 250 * 1024,
                'skipOnEmpty' => true,
            ],
            [['package_name', 'package_slug'], 'required', 'on' => 'create'],
            [['package_inclusion'], 'required', 'on' => 'inclusion'],
            [['package_exclusion'], 'required', 'on' => 'exclusion'],
            [['no_of_day', 'no_of_night', 'no_of_safari', 'stay_category_id', 'status'], 'integer'],
            [['cost_per_person'], 'number'],
            [['package_description', 'package_inclusion', 'package_exclusion', 'package_terms_condtition', 'privacy_policy', 'change_policy', 'what_you_must_carry'], 'string'],
            [['package_feature', 'package_included', 'package_park', 'package_image'], 'safe'],
            [['package_name'], 'string', 'max' => 512],
            [['package_slug'], 'string', 'max' => 720],
            [['start_location', 'end_location'], 'string', 'max' => 255],
        ];
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = [
            'package_name', 'package_image', 'package_slug', 'no_of_day', 'no_of_night', 'no_of_safari',
            'stay_category_id', 'status', 'cost_per_person', 'package_description',
            'package_inclusion', 'package_exclusion', 'package_terms_condtition',
            'package_feature', 'package_included', 'package_park', 'package_image',
            'start_location', 'end_location'
        ];
        $scenarios['update'] = [
            'package_name', 'package_image', 'package_slug', 'no_of_day', 'no_of_night', 'no_of_safari',
            'stay_category_id', 'status', 'cost_per_person', 'package_description',
            'package_inclusion', 'package_exclusion', 'package_terms_condtition',
            'package_feature', 'package_included', 'package_park', 'package_image',
            'start_location', 'end_location'
        ];
        $scenarios['inclusion'] = ['package_inclusion', 'package_exclusion', 'package_included'];
        $scenarios['additional_info'] = ['package_terms_condtition', 'privacy_policy', 'change_policy', 'what_you_must_carry'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'package_name' => 'Package Name',
            'package_slug' => 'Package Slug',
            'no_of_day' => 'Number Of Days',
            'no_of_night' => 'Number Of Nights',
            'no_of_safari' => 'Number Of Safaries',
            'start_location' => 'Start Location',
            'end_location' => 'End Location',
            'package_image' => 'Package Image',
            'stay_category_id' => 'Stay Category',
            'cost_per_person' => 'Cost Per Person',
            'package_description' => 'Package Description',
            'package_inclusion' => 'Package Inclusion',
            'package_exclusion' => 'Package Exclusion',
            'package_terms_condtition' => 'Package Terms Condtition',
            'status' => 'Status',
        ];
    }

    /**
     * Initialize Form Model
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->package_model->package_name = $this->package_name;
        $this->package_model->package_slug = $this->package_slug;
        $this->package_model->no_of_day = $this->no_of_day;
        $this->package_model->no_of_night = $this->no_of_night;
        $this->package_model->no_of_safari = $this->no_of_safari;
        $this->package_model->start_location = $this->start_location;
        $this->package_model->end_location = $this->end_location;
        $this->package_model->stay_category_id = $this->stay_category_id;
        $this->package_model->cost_per_person = $this->cost_per_person;
        $this->package_model->package_description = $this->package_description;
        $this->package_model->package_inclusion = $this->package_inclusion;
        $this->package_model->package_exclusion = $this->package_exclusion;
        $this->package_model->package_terms_condtition = $this->package_terms_condtition;
        $this->package_model->privacy_policy = $this->privacy_policy;
        $this->package_model->change_policy = $this->change_policy;
        $this->package_model->what_you_must_carry = $this->what_you_must_carry;
        $this->package_model->status = $this->status;
    }

    /**
     * Upload Banner image
     *
     * @return void
     */
    public function UploadFile()
    {
        if ($this->package_image) {
            $storagePath = Yii::$app->params['datapath'] . '/package';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->package_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'package_image' . '-' . time() . '.' . $this->package_image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->package_image->saveAs($filePath)) {
                $this->package_model->package_image = $fileName;
                $this->package_model->save(false);
            }
        }
    }
}
