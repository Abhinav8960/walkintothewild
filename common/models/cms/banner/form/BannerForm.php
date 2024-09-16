<?php

namespace common\models\cms\banner\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\cms\banner\Banner;

class BannerForm extends model
{
    public $page_id;
    public $image;
    public $status;
    public $status_option = [];
    public $banner_model;


    public function __construct(Banner $banner_model = null)
    {

        $this->banner_model = Yii::createObject([
            'class' => Banner::className()
        ]);

        if ($banner_model  != '') {
            $this->banner_model = $banner_model;
            $this->page_id = $this->banner_model->page_id;
            $this->status = $this->banner_model->status;
        }

        $this->status_option = GeneralModel::newstatusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_id', 'image'], 'required', 'on' => 'create'],
            [['page_id'], 'required', 'on' => 'update'],
            [['status', 'page_id'], 'integer'],
            [['status'], 'default', 'value' => 1],

            [
                ['image',], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
                // 'minWidth' => 1920,
                // 'maxWidth' => 1920,
                // 'maxHeight' => 220,
                // 'minHeight' => 220,
                'maxSize' => 250 * 1024
            ],
        ];
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = [
            'page_id', 'image', 'status'
        ];
        $scenarios['update'] = [
            'page_id', 'image', 'status'
        ];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'page_id' => 'Page',
            'image' => 'Banner Image',
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
        $this->banner_model->page_id = $this->page_id;
        $this->banner_model->status = $this->status;
    }



    public function uploadFile()
    {

        if ($this->image) {
            $storagePath = Yii::$app->params['datapath'] . '/banner';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->banner_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'baneer' . time() . '.' . $this->image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->image->saveAs($filePath)) {
                $this->banner_model->image = $fileName;
                $this->banner_model->save(false);
            }
        }
    }
}
