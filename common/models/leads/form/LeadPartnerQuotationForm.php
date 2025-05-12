<?php

namespace common\models\leads\form;

use common\models\leads\Lead;
use common\models\leads\LeadPartnerQuotes;
use Yii;
use yii\base\Model;
use common\models\park\SafariPark;

/**
 * OperatorQuoteForm is the model behind the contact form.
 */
class LeadPartnerQuotationForm extends Model
{

    public $lead_partner_id;
    public $lead_id;
    public $partner_id;
    public $safari;
    public $travellers;
    public $stay_category_id;
    public $name;
    public $email;
    public $phone;
    public $start_date;
    public $partner_selling_price;
    public $plateform_partner_fees_percentage = 10;
    public $plateform_partner_fees;
    public $partner_net_selling_price;
    public $plateform_customer_discount;
    public $net_payment_price;
    public $installment = 1;
    public $recived_amount;
    public $end_date;
    public $addtional_data;
    public $status;

    public $action_url;
    public $action_validate_url;



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['addtional_data', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['recived_amount'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['lead_partner_id', 'lead_id', 'partner_id', 'safari', 'travellers', 'stay_category_id', 'name', 'email', 'phone', 'start_date', 'partner_selling_price', 'plateform_partner_fees_percentage', 'partner_net_selling_price', 'net_payment_price', 'end_date'], 'required'],
            [['lead_partner_id', 'lead_id', 'partner_id', 'safari', 'travellers', 'stay_category_id', 'plateform_partner_fees_percentage', 'installment', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['start_date', 'end_date', 'addtional_data', 'action_url', 'action_validate_url'], 'safe'],
            [['partner_selling_price', 'plateform_partner_fees', 'partner_net_selling_price', 'plateform_customer_discount', 'net_payment_price', 'recived_amount'], 'number'],
            [['name', 'email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lead_partner_id' => 'Lead Partner ID',
            'lead_id' => 'Lead ID',
            'partner_id' => 'Partner ID',
            'safari' => 'Safari',
            'travellers' => 'Travellers',
            'stay_category_id' => 'Stay Category ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'start_date' => 'Start Date',
            'partner_selling_price' => 'Partner Selling Price',
            'plateform_partner_fees_percentage' => 'Plateform Partner Fees Percentage',
            'plateform_partner_fees' => 'Plateform Partner Fees',
            'partner_net_selling_price' => 'Partner Net Selling Price',
            'plateform_customer_discount' => 'Plateform Customer Discount',
            'net_payment_price' => 'Net Payment Price',
            'installment' => 'Installment',
            'recived_amount' => 'Recived Amount',
            'end_date' => 'End Date',
            'addtional_data' => 'Addtional Data',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function request()
    {

        $transaction = \Yii::$app->db->beginTransaction();
        try {

            $lpq = new LeadPartnerQuotes();
            $lpq->lead_partner_id = $this->lead_partner_id;
            $lpq->lead_id = $this->lead_id;
            $lpq->partner_id = $this->partner_id;
            $lpq->safari = $this->safari;
            $lpq->travellers = $this->travellers;
            $lpq->stay_category_id = $this->stay_category_id;
            $lpq->name = $this->name;
            $lpq->email = $this->email;
            $lpq->phone = $this->phone;
            $lpq->start_date = $this->start_date;
            $lpq->partner_selling_price = $this->partner_selling_price;
            $lpq->plateform_partner_fees_percentage = $this->plateform_partner_fees_percentage;
            $lpq->plateform_partner_fees = $this->plateform_partner_fees;
            $lpq->partner_net_selling_price = $this->partner_net_selling_price;
            $lpq->plateform_customer_discount = $this->plateform_customer_discount;
            $lpq->net_payment_price = $this->net_payment_price;
            $lpq->installment = $this->installment;
            $lpq->recived_amount = $this->recived_amount;
            $lpq->end_date = $this->end_date;
            $lpq->addtional_data = $this->addtional_data;
            $lpq->status = 1;
            $lpq->save(false);



            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            // If any exception occurs, rollback the transaction
            $transaction->rollBack();
            throw $e; // Re-throw the exception to handle it higher up
        }
    }
}
