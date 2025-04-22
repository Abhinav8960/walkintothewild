<?php

namespace common\models\compliancedocuments\form;

use common\models\compliancedocuments\ComplianceDocuments;
use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use Ramsey\Uuid\Uuid;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Deployment Phase
 */
class ComplianceDocumentsForm extends model
{
    public $uuid;
    public $title;
    public $policy_for;
    public $effective_from;
    public $version;
    public $description;
    public $status;
    public $status_option = [];
    public $cdocument_model;


    public function __construct(ComplianceDocuments $cdocument_model = null)
    {

        $this->cdocument_model = Yii::createObject([
            'class' => ComplianceDocuments::className()
        ]);

        $this->uuid = Uuid::uuid4()->toString().'-'.date('ymdHi');;
        $this->version = 'v1';

        if ($cdocument_model  != null) {
            $this->cdocument_model = $cdocument_model;
            $this->uuid =  $this->cdocument_model->uuid;
            $this->title =  $this->cdocument_model->title;
            $this->policy_for =  $this->cdocument_model->policy_for;
            $this->effective_from =  $this->cdocument_model->effective_from;
            $this->description = $this->cdocument_model->description;
            $this->version = $this->cdocument_model->version;
            $this->status = $this->cdocument_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title','policy_for','description', 'effective_from'], 'required'],
            [['status'], 'integer'],
            [['uuid','version'],'safe'],
            [['status'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title'=>'Title',
            'policy_form'=>'Policy For',
            'effective_from' => 'Effective From',
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
        $this->cdocument_model->uuid = $this->uuid;
        $this->cdocument_model->title = $this->title;
        $this->cdocument_model->policy_for = $this->policy_for;
        $this->cdocument_model->effective_from = GeneralModel::DateFormatForDb($this->effective_from);
        $this->cdocument_model->description = $this->description;
        $this->cdocument_model->version = $this->version;
        $this->cdocument_model->status = $this->status;
    }
}
