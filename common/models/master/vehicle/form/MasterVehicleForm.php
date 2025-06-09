<?php

namespace common\models\master\vehicle\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\vehicle\MasterVehicle;
use yii\web\UploadedFile;

/**
 * Update and Create Holiday
 */
class MasterVehicleForm extends model
{
    public $vehicle_name;
    public $icon;
    public $status;
    public $status_option = [];
    public $vehicle_model;
    public $created_at;


    public function __construct(MasterVehicle $vehicle_model = null)
    {

        $this->vehicle_model = Yii::createObject([
            'class' => MasterVehicle::className()
        ]);



        if ($vehicle_model  != '') {
            $this->vehicle_model = $vehicle_model;
            $this->vehicle_name = $this->vehicle_model->vehicle_name;
            $this->icon = $this->vehicle_model->icon;
            $this->status = $this->vehicle_model->status;
            $this->created_at = $this->vehicle_model->created_at;
        }

        $this->status_option = GeneralModel::newstatusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehicle_name'], 'required'],
            [['status'], 'integer'],
            [['vehicle_name'], 'string', 'max' => 125],
            [['status'], 'default', 'value' => 1],
            [['icon'],'safe'],
            [
                ['icon'],
                'image',
                'extensions' => ['jpeg', 'jpg', 'png'],
                'minWidth' => 75,
                'maxWidth' => 75,
                'maxHeight' => 75,
                'minHeight' => 75,
                'maxSize' => 100 * 1024
            ],
            [
                ['vehicle_name'],
                'unique',
                'targetClass' => MasterVehicle::className(),
                'message' => 'This vehicle name has already been taken.',
                'filter' => function ($query) {
                    if (!$this->vehicle_model->isNewRecord) {
                        $query->andWhere(['not', ['id' => $this->vehicle_model->id]]);
                    }
                }
            ],
            [['created_at'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'vehicle_name' => 'Vehicle Name',
            'icon' => 'Icon  (JPEG /JPG or PNG / 75 Pixels x 75 Pixels / 150 KB)',
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
        // $this->vehicle_model->icon = $this->icon;
        $this->vehicle_model->vehicle_name = $this->vehicle_name;
        $this->vehicle_model->status = $this->status;
    }


    public function uploadFile()
    {
        // if ($this->icon) {
        //     $storagePath = Yii::$app->params['datapath'] . '/vehicle';

        //     if (!file_exists($storagePath)) {
        //         mkdir($storagePath);
        //         chmod($storagePath, 0777);
        //     }
        //     $storagePath = $storagePath . '/' . $this->vehicle_model->id;
        //     if (!file_exists($storagePath)) {
        //         mkdir($storagePath);
        //         chmod($storagePath, 0777);
        //     }

        //     $fileName = 'vehicle' . time() . '.' . $this->icon->extension;
        //     $filePath = $storagePath . '/' . $fileName;

        //     if ($this->icon->saveAs($filePath)) {
        //         $this->vehicle_model->icon = $fileName;
        //         $this->vehicle_model->save(false);
        //     }
        // }
        // __________________________________________Move To S3 (9 June 2025)___________________________________________
        if ($this->icon) {
            $storagePath = 'vehicle' . '/' . date('ym', $this->created_at);
            $fileName = $this->vehicle_model->id . '_icon_' . time() . '.' . $this->icon->extension;

            $filePath = $storagePath . '/' . $fileName;

            if ($fileName) {
                if ($etag =  \common\Helper\FsHelper::saveUploadedFile($this->icon, $filePath, $fileName, true)) {
                    $this->vehicle_model->icon = $fileName;
                    $this->vehicle_model->icon_path = $filePath;
                    $this->vehicle_model->original_icon_name = $this->icon->name;
                    $this->vehicle_model->save(false);
                }
            }
        }
    }
}
