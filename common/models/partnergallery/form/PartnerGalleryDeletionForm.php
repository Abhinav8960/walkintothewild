<?php

namespace common\models\partnergallery\form;

use Yii;
use yii\base\Model;
use common\models\partnergallery\PartnerGallery;

class PartnerGalleryDeletionForm extends model
{

    public $deletion_model;
    public $delete_reason;
    public $status;


    public function __construct(?PartnerGallery $deletion_model = null)
    {

        $this->deletion_model = Yii::createObject([
            'class' => PartnerGallery::class
        ]);



        if ($deletion_model  != '') {
            $this->deletion_model = $deletion_model;
            $this->delete_reason = $this->deletion_model->delete_reason;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['delete_reason', 'status'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'delete_reason' => 'Delete Reason',
        ];
    }
    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->deletion_model->delete_reason = $this->delete_reason;
        $this->deletion_model->status = $this->status;
    }
}
