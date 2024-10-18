<?php

namespace common\models\master\userflag\form;

use common\models\GeneralModel;
use common\models\master\userflag\MasterUserFlag;
use Yii;
use yii\base\Model;

/**
 * MasterUserFlagForm form
 */
class MasterUserFlagForm extends Model
{
    public $user_flag;
    public $description;
    public $status;
    public $status_option = [];
    public $user_flag_model;

    public function __construct(MasterUserFlag $user_flag_model = null)
    {
        $this->user_flag_model = Yii::createObject([
            'class' => MasterUserFlag::className()
        ]);
        if ($user_flag_model != null) {
            $this->user_flag_model = $user_flag_model;
            $this->user_flag = $this->user_flag_model->user_flag;
            $this->description = $this->user_flag_model->description;
            $this->status = $this->user_flag_model->status;
        }
        $this->status_option = GeneralModel::newstatusoption();
    }

    public function rules()
    {
        return [
            [['user_flag','description'], 'required'],
            [['status'], 'integer'],
            [['user_flag','description'], 'string', 'max' => 512],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_flag' => 'User Flag',
            'description' => 'Description',
            'status' => 'Status',
        ];
    }

    public function initializeForm()
    {
        $this->user_flag_model->user_flag = $this->user_flag;
        $this->user_flag_model->description = $this->description;
        $this->user_flag_model->status = $this->status;
    }
}
