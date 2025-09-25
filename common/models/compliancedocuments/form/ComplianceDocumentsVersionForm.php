<?php

namespace common\models\compliancedocuments\form;

use common\models\compliancedocuments\ComplianceDocuments;
use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\compliancedocuments\ComplianceDocumentsVersion;


/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Deployment Phase
 */
class ComplianceDocumentsVersionForm extends model
{
    public $title;
    public $version;
    public $content;
    public $effective_date;
    public $cdocument_model;
    public $type;

    public $status;

    public function __construct(?ComplianceDocumentsVersion $cdocument_model = null)
    {
        $this->cdocument_model = Yii::createObject([
            'class' => ComplianceDocumentsVersion::class
        ]);
        $this->version = 'v1';
        if ($cdocument_model  != null) {
            $this->cdocument_model = $cdocument_model;
            $this->type =  $this->cdocument_model->type;
            $this->content =  $this->cdocument_model->content;
            $this->status = $this->cdocument_model->status;
            $this->version = $this->cdocument_model->version;
            $this->effective_date = $this->cdocument_model->effective_date;          
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'content'], 'required'],
            [['status'], 'default', 'value' => 0],
            [['status','type'], 'integer'],
            [['content','version'], 'string'],
        ];
    }
    

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'=>'Id',
            'type'=>'Type',
            'version'=>'Version',
            'content' => 'Content',
            'status' =>'Status',
            'effectiv_date'=>'Effective Date'
        ];
    }

    /**
     * Initial Form Values
     *
     * @return void
     */

    public function initializeForm()
    {
        $this->cdocument_model->type = $this->type;
        $this->cdocument_model->version = $this->version;
        $this->cdocument_model->content = $this->content;
        $this->cdocument_model->status  = $this->status;
        $this->cdocument_model->effective_date = $this->effective_date;
    }
}
