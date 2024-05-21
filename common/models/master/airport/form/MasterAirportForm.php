<?php

namespace common\models\master\airport\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\airport\MasterAirport;
use yii\web\UploadedFile;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Holiday
 */
class MasterAirportForm extends model
{
    public $slug;
    public $name;
    public $status;
    public $status_option = [];
    public $airport_model;


    public function __construct(MasterAirport $airport_model = null)
    {

        $this->airport_model = Yii::createObject([
            'class' => MasterAirport::className()
        ]);



        if ($airport_model  != '') {
            $this->airport_model = $airport_model;
            $this->slug = $this->airport_model->slug;
            $this->name = $this->airport_model->name;
            $this->status = $this->airport_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
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
        $this->airport_model->slug = $this->slug;
        $this->airport_model->name = $this->name;
        $this->airport_model->status = $this->status;
    }


    // public function uploadFile()
    // {
    //     if ($this->image) {
    //         $storagePath = Yii::$app->params['datapath'] . '/airport';

    //         if (!file_exists($storagePath)) {
    //             mkdir($storagePath);
    //             chmod($storagePath, 0777);
    //         }
    //         $storagePath = $storagePath . '/' . $this->airport_model->id;
    //         if (!file_exists($storagePath)) {
    //             mkdir($storagePath);
    //             chmod($storagePath, 0777);
    //         }

    //         $fileName = 'airport' . time() . '.' . $this->image->extension;
    //         $filePath = $storagePath . '/' . $fileName;

    //         if ($this->image->saveAs($filePath)) {
    //             $this->airport_model->image = $fileName;
    //             $this->airport_model->save(false);
    //         }
    //     }
    // }
}
