<?php

namespace common\models\transaction\form;

use Yii;
use yii\base\Model;
use common\models\transaction\Transaction;
use yii\helpers\Html;

class TransactionUpdateDetailForm extends model
{
    public $transation_update_detail_model;
    public $payment_received_at_bank;
    public $amount_received_at_bank;
    public $payu_charges;

    public function __construct(?Transaction $transation_update_detail_model = null)
    {
        $this->transation_update_detail_model = Yii::createObject([
            'class' => Transaction::className()
        ]);

        if ($transation_update_detail_model  != '') {
            $this->transation_update_detail_model = $transation_update_detail_model;
            $this->payment_received_at_bank = $this->transation_update_detail_model->payment_received_at_bank;
            $this->amount_received_at_bank = $this->transation_update_detail_model->amount_received_at_bank;
            $this->payu_charges = $this->transation_update_detail_model->payu_charges;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['payment_received_at_bank', 'required', 'requiredValue' => 1, 'message' => 'You must check this box.'],
            [['payment_received_at_bank', 'amount_received_at_bank', 'payu_charges'], 'integer'],
            [['amount_received_at_bank', 'payu_charges'], 'number', 'min' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'payment_received_at_bank' => 'Payment Received At Bank',
            'amount_received_at_bank' => 'Amount Received At Bank',
            'payu_charges' => 'PayU Charges',
        ];
    }

    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->transation_update_detail_model->payment_received_at_bank = $this->payment_received_at_bank;
        $this->transation_update_detail_model->amount_received_at_bank = $this->amount_received_at_bank;
        $this->transation_update_detail_model->payu_charges = $this->payu_charges;
    }
}
