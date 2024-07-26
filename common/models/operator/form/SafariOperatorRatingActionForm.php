<?php

namespace common\models\operator\form;

use common\models\operator\SafariOperatorRatingReport;
use common\models\User;
use Yii;
use yii\base\Model;


class SafariOperatorRatingActionForm extends model
{
    public $comment_action_model;
    public $status;
    public $reason;
    public $user_id;


    public function __construct(SafariOperatorRatingReport $comment_action_model = null)
    {

        $this->comment_action_model = Yii::createObject([
            'class' => SafariOperatorRatingReport::className()
        ]);


        if ($comment_action_model  != '') {
            $this->comment_action_model = $comment_action_model;
            $this->status =  $this->comment_action_model->status;
            $this->reason =  $this->comment_action_model->reason;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {


        return [
            [['status', 'user_id'], 'integer'],
            [['status', 'reason'], 'required']


        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'user_id' => 'User Id',
            'reason' => 'Reason',
        ];
    }
    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->comment_action_model->status =  $this->status;
        $this->comment_action_model->reason =  $this->reason;

        if ($this->status == 20) {
            $model = User::find()->where(['id' => $this->comment_action_model->user_id])->limit(1)->one();
            $model->blocked_at = time();
            $model->save(false);
        }
    }
}
