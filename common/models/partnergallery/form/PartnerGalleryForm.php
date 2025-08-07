<?php

namespace common\models\partnergallery\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\operator\SafariOperatorPark;
use common\models\partnergallery\PartnerGallery;

class PartnerGalleryForm extends model
{
    public $title;
    public $safari_operator_id;
    public $listing_status;
    public $status_option = [];
    public $partner_gallery_model;

    public $park_id;  
    public $edit_status;


    public function __construct(?PartnerGallery $partner_gallery_model = null)
    {

        $this->partner_gallery_model = Yii::createObject([
            'class' => PartnerGallery::class
        ]);



        if ($partner_gallery_model  != '') {
            $this->partner_gallery_model = $partner_gallery_model;
            $this->title = $this->partner_gallery_model->title;
            $this->safari_operator_id = $this->partner_gallery_model->safari_operator_id;
            $this->park_id = $this->partner_gallery_model->park_id;
            $this->edit_status = $this->partner_gallery_model->edit_status;
            $this->listing_status = $this->partner_gallery_model->listing_status;
        }

        $this->status_option = GeneralModel::newstatusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'listing_status', 'park_id'], 'required'],
            [['listing_status', 'safari_operator_id', 'park_id', 'edit_status'], 'integer'],
            [['title'], 'string', 'max' => 255],
            // [['title'], 'validateUniqueTitle'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Title',
            'safari_operator_id' => 'Safari Operator ID',
            'park_id' => "Park ID",
            'listing_status' => 'Listing Status',
        ];
    }
    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->partner_gallery_model->title = $this->title;
        $this->partner_gallery_model->safari_operator_id = $this->safari_operator_id;
        $this->partner_gallery_model->park_id = $this->park_id;
        $this->partner_gallery_model->edit_status = $this->edit_status;
        $this->partner_gallery_model->listing_status = $this->listing_status;
    }

    public function validateUniqueTitle($attribute, $params)
    {
        $exists = PartnerGallery::find()
            ->where([
                'title' => $this->title,
                'safari_operator_id' => $this->safari_operator_id,
            ])
            ->exists();

        if ($exists) {
            $this->addError($attribute, 'The Title has already been taken.');
        }
    }
}
