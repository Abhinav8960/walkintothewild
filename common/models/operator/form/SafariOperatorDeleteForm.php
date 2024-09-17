<?php

namespace common\models\operator\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\operator\SafariOperator;

class SafariOperatorDeleteForm extends model
{

    public $delete_reason_id;
    public $delete_reason;
    public $status;
    public $status_option = [];
    public $safari_operator_delete_model;


    public function __construct(SafariOperator $safari_operator_delete_model = null)
    {

        $this->safari_operator_delete_model = Yii::createObject([
            'class' => SafariOperator::className()
        ]);



        if ($safari_operator_delete_model  != '') {
            $this->safari_operator_delete_model = $safari_operator_delete_model;
            $this->delete_reason_id              =  $this->safari_operator_delete_model->delete_reason_id;
            $this->delete_reason              =  $this->safari_operator_delete_model->delete_reason;
            $this->status              =  $this->safari_operator_delete_model->status;
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
        $this->safari_operator_delete_model->delete_reason_id          =  $this->delete_reason_id;
        $this->safari_operator_delete_model->delete_reason          =  $this->delete_reason;
        $this->safari_operator_delete_model->status               =  $this->status;
    }
}
