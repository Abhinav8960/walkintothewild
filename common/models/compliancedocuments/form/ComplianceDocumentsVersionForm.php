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
    public $banner_image;
    public $status;

    const SCENARIO_CREATE = 'create';

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
            $this->banner_image = $this->cdocument_model->banner_image;     
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['banner_image'],
                'image',
                'extensions' => ['jpeg', 'jpg', 'png'],
                'maxSize' => 500 * 1024,
                'skipOnEmpty' => true,
                // 'maxWidth' => 350,
                // 'maxHeight' => 350,
            ],
            [['banner_image'], 'required', 'on' => self::SCENARIO_CREATE],
            [['content'], 'validateMaxWords', 'params' => ['max' => 100000]],
            [['banner_image'],'safe'],
            [['type','content'], 'required'],
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
            'effectiv_date'=>'Effective Date',
            'banner_image'=>'Banner Image'
        ];
    }

    /**
     * Initial Form Values
     *
     * @return void
     */

     public function validateMaxWords($attribute, $params)
     {
         $maxWords = $params['max'];
         $wordCount = str_word_count($this->$attribute);
         if ($wordCount > $maxWords) {
             $this->addError($attribute, "The Content must not exceed $maxWords words.");
         }
     }
    
    public function initializeForm()
    {
        $this->cdocument_model->type = $this->type;
        $this->cdocument_model->version = $this->version;
        $this->cdocument_model->content = $this->content;
        $this->cdocument_model->status  = $this->status;
        $this->cdocument_model->effective_date = $this->effective_date;
    }

    public function UploadFile()
    {
        if ($this->banner_image) {    
            $storagePath = 'compliance_documents' . '/' . date('ymd');
            $fileName =  $this->version . '_compliance_documents_banner_image' . '_' . time() . '.' . $this->banner_image->extension;
            $filePath = $storagePath . '/' . $fileName;
            if ($fileName) {
                if ($etag =  \common\Helper\FsHelper::saveUploadedFile($this->banner_image, $filePath, $fileName, true)) {
                    $this->cdocument_model->banner_image = $filePath;
                    // $this->cdocument_model->original_banner_filename = $this->banner_image->name;
                    $this->cdocument_model->save(false);
                }
            }
        }
    }
}
