<?php

namespace common\models\sharesafari\form;

use Yii;
use common\models\sharesafari\ShareSafari;


class ShareSafariStatusForm extends \yii\base\Model
{
    public $shared_safari_status_model;
    public $status;


    public function __construct(?ShareSafari $shared_safari_status_model = null)
    {
        $this->shared_safari_status_model = Yii::createObject([
            'class' => ShareSafari::class
        ]);
        if ($shared_safari_status_model  != '') {
            $this->shared_safari_status_model = $shared_safari_status_model;
            $this->status =  $this->shared_safari_status_model->status;
        }
    }

    public function rules()
    {
        return [
            [['status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
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
        $this->shared_safari_status_model->status = $this->status;
    }


}
