<?php

namespace common\models\deployment\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\deployment\DeploymentPhase;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Deployment Phase
 */
class DeploymentPhaseForm extends model
{
    public $date;
    public $description;
    public $version;
    public $status;
    public $status_option = [];
    public $phase_model;


    public function __construct(DeploymentPhase $phase_model = null)
    {

        $this->phase_model = Yii::createObject([
            'class' => DeploymentPhase::className()
        ]);



        if ($phase_model  != '') {
            $this->phase_model = $phase_model;
            $this->date =  $this->phase_model->date;
            $this->description = $this->phase_model->description;
            $this->version = $this->phase_model->version;
            $this->status = $this->phase_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['version', 'description', 'date'], 'required'],
            [['status'], 'integer'],
            [['version'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'date' => 'Date Time',
            'version' => 'Version',
            'description' => 'Description',
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
        $this->phase_model->date = GeneralModel::DateFormatForDb($this->date);
        $this->phase_model->description = $this->description;
        $this->phase_model->version = $this->version;
        $this->phase_model->status = $this->status;
    }
}
