<?php

namespace common\models\cms\sharedsafaribanner\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\cms\sharedsafaribanner\SharedSafariBanner;

/**
 * @author Aayush Kuamr <aayushsaini9999@gmial.com>
 * 
 */
class SharedSafariBannerForm extends model
{

    public $file;
    public $status;
    public $url;
    public $status_option = [];
    public $shared_safari_banner_model;


    public function __construct(SharedSafariBanner $shared_safari_banner_model = null)
    {

        $this->shared_safari_banner_model = Yii::createObject([
            'class' => SharedSafariBanner::className()
        ]);



        if ($shared_safari_banner_model  != '') {
            $this->shared_safari_banner_model = $shared_safari_banner_model;
            $this->url = $this->shared_safari_banner_model->url;
            $this->status = $this->shared_safari_banner_model->status;
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
                return $model->shared_safari_banner_model->shared_safari_banner != '';
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
            'file' => 'Shared Safari Banner',
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
        $this->shared_safari_banner_model->url = $this->url;
        $this->shared_safari_banner_model->status = $this->status;
    }

    public function uploadFile()
    {
        if ($this->file) {
            $storagePath = Yii::$app->params['datapath'] . '/shared_safari_banner';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->shared_safari_banner_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'shared_safari_banner_' . time() . '.' . $this->file->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->file->saveAs($filePath)) {
                $this->shared_safari_banner_model->shared_safari_banner = $fileName;
                $this->shared_safari_banner_model->save(false);
            }
        }
    }
}
