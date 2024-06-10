<?php

namespace frontend\models;

use common\models\operator\OperatorQuote;
use common\models\operator\SafariOperator;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class OperatorQuoteForm extends Model
{
    public $comment;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['safari_park_id'], 'required'],
            [['phone_no'], 'match', 'pattern' => '/^[123456789]\d{9}$/', 'message' => 'Invalid Phone number.'],
            [['email'], 'email'],
            [['safari_park_id', 'safaris', 'travelers', 'stay_category_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['full_name', 'email', 'start_date', 'end_date', 'user_agent'], 'string', 'max' => 255],
            [['phone_no'], 'string', 'max' => 12],
            [['ip_address'], 'string', 'max' => 45],
        ];
    }


    /**
     * Save Contatc Query
     *
     * @param Corporate $corporate
     * @return void
     */
    public function request(SafariOperator $operator)
    {

        $agent = new \Jenssegers\Agent\Agent();
        $agent->setUserAgent(Yii::$app->request->userAgent);
        $operator_quote = new OperatorQuote();
        $operator_quote->safari_park_id = $this->safari_park_id;
        $operator_quote->safaris = $this->safaris;
        $operator_quote->travelers = $this->travelers;
        $operator_quote->stay_category_id = $this->stay_category_id;
        $operator_quote->full_name = $this->full_name;
        $operator_quote->email = $this->email;
        $operator_quote->start_date = $this->start_date;
        $operator_quote->end_date = $this->end_date;
        $operator_quote->phone_no = $this->phone_no;
        $operator_quote->operator_id = $operator->id;
        $operator_quote->ip_address = Yii::$app->getRequest()->getUserIp();
        $operator_quote->device_type = $agent->device();
        $operator_quote->browser = $agent->browser();
        $operator_quote->os = $agent->platform();
        $operator_quote->status = 1;


        if ($operator_quote->save()) {
            return $operator_quote->save();
        }
    }
}
