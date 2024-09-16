<?php

namespace common\models\master\bonusexperience\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\bonusexperience\MasterBonusExperience;

/**
 * Update and Create Holiday
 */
class MasterBonusExperienceForm extends model
{
    public $title;
    public $status;
    public $status_option = [];
    public $bonus_experience_model;


    public function __construct(MasterBonusExperience $bonus_experience_model = null)
    {

        $this->bonus_experience_model = Yii::createObject([
            'class' => MasterBonusExperience::className()
        ]);



        if ($bonus_experience_model  != '') {
            $this->bonus_experience_model = $bonus_experience_model;
            $this->title = $this->bonus_experience_model->title;
            $this->status = $this->bonus_experience_model->status;
        }

        $this->status_option = GeneralModel::newstatusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],
            [
                ['title'], 'unique', 'targetClass' => MasterBonusExperience::className(), 'message' => 'This title has already been taken.',
                'filter' => function ($query) {
                    if (!$this->bonus_experience_model->isNewRecord) {
                        $query->andWhere(['not', ['id' => $this->bonus_experience_model->id]]);
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
        $this->bonus_experience_model->title = $this->title;
        $this->bonus_experience_model->status = $this->status;
    }
}
