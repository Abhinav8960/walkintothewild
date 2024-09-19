<?php

namespace common\models\article\frequency\form;

use common\models\article\frequency\Frequency;
use common\models\GeneralModel;
use Yii;
use yii\base\Model;

/**
 * Class FrequencyForm
 * @package common\models\frequency\form
 */
class FrequencyForm extends Model
{
    public $frequency;
    public $status;
    public $status_option = [];

    /**
     * @var Frequency|null
     */
    public $frequency_model;

    /**
     * FrequencyForm constructor.
     * @param Frequency|null $frequency_model
     * @param array $config
     */
    public function __construct($frequency_model = null, $config = [])
    {
        $this->frequency_model = Yii::createObject([
            'class' => Frequency::className()
        ]);

        if ($frequency_model !== null) {
            $this->frequency_model = $frequency_model;
            $this->frequency = $this->frequency_model->frequency;
            $this->status = $this->frequency_model->status;
        }

        $this->status_option = GeneralModel::statusoption() ?: [];

        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['frequency', 'status'], 'required'],
            [['status'], 'integer'],
            [['frequency'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'frequency' => 'Frequency',
            'status' => 'Status',
        ];
    }

    /**
     * Initializes the form model's frequency model with the current form data.
     */
    public function initializeForm()
    {
        $this->frequency_model->frequency = $this->frequency;
        $this->frequency_model->status = $this->status;
    }
}
