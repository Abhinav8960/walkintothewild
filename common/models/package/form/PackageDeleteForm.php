<?php

namespace common\models\package\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\package\PackageVersion;

class PackageDeleteForm extends model
{

    public $delete_reason_id;
    public $delete_reason;
    public $status;
    public $status_option = [];
    public $package_delete_model;


    public function __construct(Package $package_delete_model = null)
    {

        $this->package_delete_model = Yii::createObject([
            'class' => Package::className()
        ]);



        if ($package_delete_model  != '') {
            $this->package_delete_model = $package_delete_model;
            $this->delete_reason_id              =  $this->package_delete_model->delete_reason_id;
            $this->delete_reason              =  $this->package_delete_model->delete_reason;
            $this->status              =  $this->package_delete_model->status;
        }

        $this->status_option = GeneralModel::newstatusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['delete_reason_id', 'delete_reason', 'status'], 'required'],
            [['delete_reason_id', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'delete_reason_id' => 'Delete Reason',
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
        $this->package_delete_model->delete_reason_id          =  $this->delete_reason_id;
        $this->package_delete_model->delete_reason          =  $this->delete_reason;
        $this->package_delete_model->status               =  $this->status;
    }
}
