<?php

namespace common\models\partnergallery\form;

use Yii;
use yii\base\Model;
use common\models\partnergallery\PartnerGallery;

class PartnerGalleryRejectionForm extends model
{

    public $rejection_model;
    public $remark;
    public $edit_status;

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
            [['edit_status'], 'integer'],

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
        $this->rejection_model->edit_status = $this->edit_status;
    }
}
