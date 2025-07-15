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
    public $status;
    public $status_option = [];
    public $partner_gallery_model;

    public $can_send_for_approval;
    public $park_id;
    public $in_draft;


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
            $this->in_draft = $this->partner_gallery_model->in_draft;
            $this->status = $this->partner_gallery_model->status;
        }

        $this->status_option = GeneralModel::newstatusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'status', 'park_id'], 'required'],
            [['status', 'safari_operator_id', 'can_send_for_approval', 'park_id', 'in_draft'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'validateUniqueTitle'],

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
            'status' => 'Status',
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
        $this->partner_gallery_model->in_draft = $this->in_draft;
        $this->partner_gallery_model->can_send_for_approval = $this->can_send_for_approval;
        $this->partner_gallery_model->status = $this->status;
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
