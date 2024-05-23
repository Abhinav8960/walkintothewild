<?php

namespace common\models\cms\disclaimer\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\cms\disclaimer\Disclaimer;

class DisclaimerForm extends model
{
    public $title;
    public $status;
    public $status_option = [];
    public $disclaimer_model;


    public function __construct(Disclaimer $disclaimer_model = null)
    {

        $this->disclaimer_model = Yii::createObject([
            'class' => Disclaimer::className()
        ]);

        if ($disclaimer_model  != '') {
            $this->disclaimer_model = $disclaimer_model;
            $this->title = $this->disclaimer_model->title;
            $this->status = $this->disclaimer_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 125],
            [['status'], 'default', 'value' => 1],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Title',
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
        $this->disclaimer_model->title = $this->title;
        $this->disclaimer_model->status = $this->status;
    }
}
