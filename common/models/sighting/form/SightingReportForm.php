<?php

namespace common\models\sighting\form;

use common\models\sighting\SightingReport;
use Yii;
use yii\base\Model;

/**
 * SightingForm form
 */
class SightingReportForm extends Model
{

    public $message;
    public $user_id;
    public $sighting_id;
    public $status;
    public $sighting_model;

    public function __construct(SightingReport $sighting_model = null)
    {
        $this->sighting_model = Yii::createObject([
            'class' => SightingReport::className()
        ]);
        if ($sighting_model != null) {
            $this->sighting_model = $sighting_model;
            $this->message = $this->sighting_model->message;
            $this->user_id = $this->sighting_model->user_id;
            $this->sighting_id = $this->sighting_model->sighting_id;
            $this->status = $this->sighting_model->status;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message','user_id','sighting_id'], 'required'],
            [['user_id', 'status','sighting_id'], 'integer'],
            [['message'], 'string'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'message' => 'Message',
            'sighting_id' => 'Sighting ID',
            'status' => 'Status',
        ];
    }

    public function initializeForm()
    {

        $this->sighting_model->message = $this->message;
        $this->sighting_model->user_id = $this->user_id;
        $this->sighting_model->status = $this->status;
        $this->sighting_model->sighting_id = $this->sighting_id;
    }

}
