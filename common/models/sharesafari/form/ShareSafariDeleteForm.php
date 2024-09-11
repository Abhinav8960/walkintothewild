<?php

namespace common\models\sharesafari\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\sharesafari\ShareSafari;

class ShareSafariDeleteForm extends model
{

    public $delete_reason_id;
    public $status;
    public $status_option = [];
    public $share_safari_delete_model;


    public function __construct(ShareSafari $share_safari_delete_model = null)
    {

        $this->share_safari_delete_model = Yii::createObject([
            'class' => ShareSafari::className()
        ]);



        if ($share_safari_delete_model  != '') {
            $this->share_safari_delete_model = $share_safari_delete_model;
            $this->delete_reason_id              =  $this->share_safari_delete_model->delete_reason_id;
            $this->status              =  $this->share_safari_delete_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['delete_reason_id', 'status'], 'required'],
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
        $this->share_safari_delete_model->delete_reason_id          =  $this->delete_reason_id;
        $this->share_safari_delete_model->status               =  $this->status;
    }
}
