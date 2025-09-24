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
    public $type;
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
            $this->type =  $this->cdocument_model->type;
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
            [['type', 'content'], 'required'],
            [['status'], 'default', 'value' => 0],
            [['type','compliance_documents_id','status'], 'integer'],
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
            'compliance_documents_id' => 'Compliance Documents Id',
            'type'=>'Type',
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
    private function getDocument()
    {
       $cdoc = new ComplianceDocuments();
       $cdoc->type = $this->type;
       $cdoc->version = $this->version;
       $cdoc->content = $this->content;
       $cdoc->effective_date = null;
       $cdoc->status = ComplianceDocuments::STATUS_CREATE;
       $cdoc->save(false);
       return $cdoc->id;
    }

    public function initializeForm()
    {

        if ($this->compliance_documents_id == null) {
            $docId = $this->getDocument();
            if ($docId) {
                $this->compliance_documents_id = $docId;
            }
        }
        $this->cdocument_model->compliance_documents_id = $this->compliance_documents_id;
        $this->cdocument_model->type = $this->type;
        $this->cdocument_model->version = $this->version;
        $this->cdocument_model->content = $this->content;
        $this->cdocument_model->status  = $this->status;
        $this->cdocument_model->effective_date = $this->effective_date;
    }
}
