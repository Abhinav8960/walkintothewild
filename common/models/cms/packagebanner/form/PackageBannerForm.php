<?php

namespace common\models\cms\packagebanner\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use yii\web\UploadedFile;
use common\models\cms\packagebanner\PackageBanner;



/**
 * @author Aayush Kuamr <aayushsaini9999@gmial.com>
 * 
 */
class PackageBannerForm extends model
{

    public $file;
    public $status;
    public $url;
    public $status_option = [];
    public $package_banner_model;


    public function __construct(PackageBanner $package_banner_model = null)
    {

        $this->package_banner_model = Yii::createObject([
            'class' => PackageBanner::className()
        ]);



        if ($package_banner_model  != '') {
            $this->package_banner_model = $package_banner_model;
            $this->url = $this->package_banner_model->url;
            $this->status = $this->package_banner_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['url', 'string'],
            ['file', 'file', 'when' => function ($model) {
                return $model->package_banner_model->package_banner != '';
            }],
            ['file', 'required', 'on' => 'create'],
            [
                ['file'],
                'image',
                'extensions' => ['jpeg', 'jpg', 'png'],
                'maxSize' => 250 * 1024,
            ],
            [['status'], 'default', 'value' => 1],
        ];
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['url', 'status', 'file'];
        $scenarios['update'] = ['url', 'status', 'file'];

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
        $this->package_banner_model->url = $this->url;
        $this->package_banner_model->status = $this->status;
    }

    public function uploadFile()
    {
        if ($this->file) {
            $storagePath = Yii::$app->params['datapath'] . '/package_banner';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->package_banner_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'package_banner_' . time() . '.' . $this->file->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->file->saveAs($filePath)) {
                $this->package_banner_model->package_banner = $fileName;
                $this->package_banner_model->save(false);
            }
        }
    }
}
