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
    public $safari_park_id;
    public $safari_operator_id;
    public $status;
    public $status_option = [];
    public $partner_gallery_model;


    public function __construct(PartnerGallery $partner_gallery_model = null)
    {

        $this->partner_gallery_model = Yii::createObject([
            'class' => PartnerGallery::className()
        ]);



        if ($partner_gallery_model  != '') {
            $this->partner_gallery_model = $partner_gallery_model;
            $this->title = $this->partner_gallery_model->title;
            $this->safari_park_id = $this->partner_gallery_model->safari_park_id;
            $this->safari_operator_id = $this->partner_gallery_model->safari_operator_id;
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
            [['title','safari_park_id', 'status'], 'required'],
            [['status', 'safari_operator_id', 'safari_park_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'validateUniqueTitle'],
            [
                ['safari_park_id'],
                'exist',
                'targetClass' => SafariOperatorPark::class,
                'targetAttribute' => ['safari_park_id' => 'park_id'],
                'filter' => function ($query) {
                    $query->andWhere(['safari_operator_id' => $this->safari_operator_id, 'status' => SafariOperatorPark::STATUS_ACTIVE]);
                }
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Title',
            'safari_park_id' => 'Safari Park ID',
            'safari_operator_id' => 'Safari Operator ID',
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
        $this->partner_gallery_model->safari_park_id = $this->safari_park_id;
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
