<?php

namespace common\models\partnergallery\form;

use Yii;
use yii\base\Model;
use common\models\partnergallery\PartnerGallery;

class PartnerGalleryRejectionForm extends model
{

    public $rejection_model;
    public $remark;
    public $in_draft;
    public $is_approved;
    public $send_for_approval;


    public function __construct(?PartnerGallery $rejection_model = null)
    {

        $this->rejection_model = Yii::createObject([
            'class' => PartnerGallery::class
        ]);



        if ($rejection_model  != '') {
            $this->rejection_model = $rejection_model;
            $this->remark = $this->rejection_model->remark;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['remark'], 'required'],
            [['in_draft','send_for_approval','is_approved'], 'integer'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'remark' => 'Remark',
        ];
    }
    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->rejection_model->remark = $this->remark;
        $this->rejection_model->in_draft = $this->in_draft;
        $this->rejection_model->send_for_approval = $this->send_for_approval;
        $this->rejection_model->is_approved = $this->is_approved;
    }
}
