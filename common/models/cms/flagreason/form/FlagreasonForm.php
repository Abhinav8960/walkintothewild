<?php

namespace common\models\cms\flagreason\form;

use common\models\cms\flagreason\Flagreason;
use Yii;
use yii\base\Model;
use common\models\GeneralModel;

/**
 * Class FlagreasonForm
 * @package common\models\cms\flagreason\form
 *
 * Handles the creation and updating of Flagreason models
 */
class FlagreasonForm extends Model
{
    public $reason;
    public $status;
    public $status_option = [];
    public $reason_model;

    public function __construct(Flagreason $reason_model = null, $config = [])
    {
        parent::__construct($config);

        if ($reason_model === null) {
            $this->reason_model = new Flagreason();
        } else {
            $this->reason_model = $reason_model;
            $this->reason = $this->reason_model->reason;
            $this->status = $this->reason_model->status;
        }

        $this->status_option = GeneralModel::statusOption();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reason'], 'required'],
            [['status'], 'integer'],
            [['reason'], 'string', 'max' => 512],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reason' => 'Reason',
            'status' => 'Status',
        ];
    }

    /**
     * Initialize form values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->reason_model->reason = $this->reason;
        $this->reason_model->status = $this->status;
    }
}
