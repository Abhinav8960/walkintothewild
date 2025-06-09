<?php

namespace common\models\cms\frontendbanner\form;

use common\models\cms\frontendbanner\FrontendBanner;
use Yii;
use yii\base\Model;
use common\models\GeneralModel;




/**
 * @author Aayush Kuamr <aayushsaini9999@gmial.com>
 * 
 */
class FrontendBannerForm extends model
{

    public $file;
    public $status;
    public $url;
    public $type;
    public $status_option = [];
    public $frontend_banner_model;
    public $created_at;



    public function __construct(FrontendBanner $frontend_banner_model = null)
    {

        $this->frontend_banner_model = Yii::createObject([
            'class' => FrontendBanner::className()
        ]);



        if ($frontend_banner_model  != '') {
            $this->frontend_banner_model = $frontend_banner_model;
            $this->url = $this->frontend_banner_model->url;
            $this->type = $this->frontend_banner_model->type;
            $this->status = $this->frontend_banner_model->status;
            $this->created_at = $this->frontend_banner_model->created_at;

        }

        $this->status_option = GeneralModel::newstatusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'url'], 'required'],
            [['type'], 'integer'],
            [['url'], 'url', 'defaultScheme' => 'https'],
            ['file', 'file', 'when' => function ($model) {
                return $model->frontend_banner_model->frontend_banner != '';
            }],
            ['file', 'required', 'on' => 'create'],
            [
                ['file'],
                'image',
                'extensions' => ['jpeg', 'jpg', 'png'],
                'maxSize' => 250 * 1024,
            ],
            [['status'], 'default', 'value' => 1],
            [['created_at'],'safe']

        ];
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['type', 'url', 'status', 'file'];
        $scenarios['update'] = ['type', 'url', 'status', 'file'];

        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'file' => 'Package Banner',
            'url' => 'Link',
            'type' => 'Type',
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
        $this->frontend_banner_model->url = $this->url;
        $this->frontend_banner_model->type = $this->type;
        $this->frontend_banner_model->status = $this->status;
    }

    public function uploadFile()
    {
        // if ($this->file) {
        //     $storagePath = Yii::$app->params['datapath'] . '/frontend_banner';

        //     if (!file_exists($storagePath)) {
        //         mkdir($storagePath);
        //         chmod($storagePath, 0777);
        //     }
        //     $storagePath = $storagePath . '/' . $this->frontend_banner_model->id;
        //     if (!file_exists($storagePath)) {
        //         mkdir($storagePath);
        //         chmod($storagePath, 0777);
        //     }

        //     $fileName = 'frontend_banner_' . time() . '.' . $this->file->extension;
        //     $filePath = $storagePath . '/' . $fileName;

        //     if ($this->file->saveAs($filePath)) {
        //         $this->frontend_banner_model->frontend_banner = $fileName;
        //         $this->frontend_banner_model->save(false);
        //     }
        // }

        // __________________________________________Move To S3 (9 June 2025)___________________________________________
        if ($this->file) {
            $storagePath = 'frontend_banner' . '/' . date('ym', $this->created_at);
            $fileName = 'frontend_banner_' . time() . '.' . $this->file->extension;

            $filePath = $storagePath . '/' . $fileName;

            if ($fileName) {
                if ($etag =  \common\Helper\FsHelper::saveUploadedFile($this->file, $filePath, $fileName, true)) {
                    $this->frontend_banner_model->frontend_banner = $fileName;
                    $this->frontend_banner_model->frontend_banner_path = $filePath;
                    $this->frontend_banner_model->frontend_banner_name = $this->file->name;
                    $this->frontend_banner_model->save(false);
                }
            }
        }
    }
}
