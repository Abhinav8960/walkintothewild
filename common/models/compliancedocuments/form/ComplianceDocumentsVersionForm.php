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
    public $compliance_documents_id;
    public $content;
    public $effective_date;
    public $cdocument_model;

    public $status;

    public function __construct(?ComplianceDocumentsVersion $cdocument_model = null)
    {
        $this->cdocument_model = Yii::createObject([
            'class' => ComplianceDocumentsVersion::class
        ]);
        $this->version = 'v1';
        if ($cdocument_model  != null) {
            $this->cdocument_model = $cdocument_model;
            $this->compliance_documents_id =  $this->cdocument_model->compliance_documents_id;
            $this->title =  $this->cdocument_model->title;
            $this->content =  $this->cdocument_model->content;
            $this->status = $this->cdocument_model->status;
            $this->effective_date = $this->effective_date;
            
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['status'], 'default', 'value' => 0],
            [['compliance_documents_id','status'], 'integer'],
            [['content','version','title'], 'string'],
        ];
    }
    

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'=>'Id',
            'compliance_documents_id' => 'Compliance Documents Id',
            'title'=>'Title',
            'version'=>'Version',
            'content' => 'Content',
            'status' =>'Status',
        ];
    }

    /**
     * Initial Form Values
     *
     * @return void
     */

    public function initializeForm()
    {
        $this->cdocument_model->compliance_documents_id = $this->compliance_documents_id;
        $this->cdocument_model->title = $this->title;
        $this->cdocument_model->version = $this->version;
        $this->cdocument_model->content = $this->content;
        $this->cdocument_model->status  = $this->status;
        $this->cdocument_model->effective_date = $this->effective_date;
    }
}
