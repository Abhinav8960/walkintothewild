<?php

namespace common\models\master\bird\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\bird\MasterBird;
use yii\web\UploadedFile;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Holiday
 */
class MasterBirdForm extends model
{
    public $slug;
    public $name;
    public $know_as;
    public $short_description;
    public $long_description;
    public $image;
    public $status;
    public $status_option = [];
    public $bird_type_id;
    public $bird_model;



    public function __construct(MasterBird $bird_model = null)
    {

        $this->bird_model = Yii::createObject([
            'class' => MasterBird::className()
        ]);



        if ($bird_model  != '') {
            $this->bird_model = $bird_model;
            $this->image = $this->bird_model->image;
            $this->slug = $this->bird_model->slug;
            $this->know_as = $this->bird_model->know_as;
            $this->name = $this->bird_model->name;
            $this->short_description = $this->bird_model->short_description;
            $this->long_description = $this->bird_model->long_description;
            $this->status = $this->bird_model->status;
            $this->bird_type_id = $this->bird_model->bird_type_id;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'short_description', 'bird_type_id'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 125],
            [['name', 'slug', 'know_as'], 'string', 'max' => 125],
            [['short_description'], 'string', 'max' => 255],
            [['long_description'], 'string', 'max' => 512],
            [['status'], 'default', 'value' => 1],
            [['long_description'], 'safe'],
            [
                ['image'], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
                // 'minWidth' => 285,
                // 'maxWidth' => 285,
                // 'maxHeight' => 285,
                // 'minHeight' => 285,
                'maxSize' => 250 * 1024
            ],
            [
                ['name'], 'unique', 'targetClass' => MasterBird::className(), 'message' => 'This name has already been taken.',
                'filter' => function ($query) {
                    if (!$this->bird_model->isNewRecord) {
                        $query->andWhere(['not', ['id' => $this->bird_model->id]]);
                    }
                }
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'image' => 'Image  (JPEG /JPG or PNG / 350 Pixels x 350 Pixels / 100 KB)',
            'status' => 'Status',
            'bird_type_id' => 'Bird Type'

        ];
    }
    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->bird_model->slug = $this->slug;
        $this->bird_model->know_as = $this->know_as;
        $this->bird_model->name = $this->name;
        $this->bird_model->short_description = $this->short_description;
        $this->bird_model->long_description = $this->long_description;
        $this->bird_model->status = $this->status;
        $this->bird_model->bird_type_id = $this->bird_type_id;
    }


    public function uploadFile()
    {

        if ($this->image) {
            $storagePath = Yii::$app->params['datapath'] . '/bird';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->bird_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'bird' . time() . '.' . $this->image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->image->saveAs($filePath)) {
                $this->bird_model->image = $fileName;
                $this->bird_model->save(false);
            }
        }
    }
}
