<?php

namespace common\models\sighting\form;

use common\models\sighting\Sighting;
use Yii;
use yii\base\Model;


/**
 * SightingDeleteForm is the model behind the reply form.
 */
class SightingDeleteForm extends Model
{
    public $delete_reason;
    public $status;
    public $sighting_delete_model;


    public function __construct(Sighting $sighting_delete_model = null)
    {

        $this->sighting_delete_model = Yii::createObject([
            'class' => Sighting::className()
        ]);

        if ($sighting_delete_model  != '') {
            $this->sighting_delete_model    = $sighting_delete_model;
            $this->delete_reason       =  $this->sighting_delete_model->delete_reason;
            $this->status              =  $this->sighting_delete_model->status;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['delete_reason'], 'required'],
            [['delete_reason'], 'string', 'max' => 512],
            [['status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'delete_reason' => 'Delete Reason',
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
        $this->sighting_delete_model->delete_reason          =  $this->delete_reason;
        $this->sighting_delete_model->status               =  $this->status;
    }
}
