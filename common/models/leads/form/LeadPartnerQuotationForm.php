<?php

namespace common\models\leads\form;

use common\models\leads\Lead;
use common\models\leads\LeadPartnerQuoteInstallments;
use common\models\leads\LeadPartnerQuotes;
use Yii;
use yii\base\Model;
use common\models\park\safarisPark;

/**
 * OperatorQuoteForm is the model behind the contact form.
 */
class LeadPartnerQuotationForm extends Model
{

    public $lead_partner_id;
    public $park_id;
    public $addional_notes;
    public $lead_id;
    public $partner_id;
    public $safaris;
    public $travelers;
    public $stay_category_id;
    public $name;
    public $email;
    public $phone;
    public $start_date;
    public $partner_selling_price;
    public $plateform_partner_fees_percentage = 10;
    public $plateform_partner_fees;
    public $partner_net_selling_price;
    public $plateform_customer_discount = 0;
    public $net_payment_price;
    public $installment = 1;
    public $received_amount = 0;
    public $end_date;
    public $addtional_data;
    public $status;

    public $action_url;
    public $action_validate_url;
    public $validity_date_time;
    public $permit_booking_date;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['addtional_data', 'addional_notes'], 'default', 'value' => null],
            [['received_amount'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['park_id', 'lead_partner_id', 'lead_id', 'partner_id', 'safaris', 'travelers', 'stay_category_id', 'start_date', 'partner_selling_price', 'plateform_partner_fees_percentage', 'end_date'], 'required'],
            [['lead_partner_id', 'lead_id', 'partner_id', 'safaris', 'travelers', 'stay_category_id', 'plateform_partner_fees_percentage', 'installment', 'status'], 'integer'],
            [['start_date', 'end_date', 'addtional_data', 'action_url', 'action_validate_url', 'name', 'email', 'phone'], 'safe'],
            [['partner_selling_price', 'plateform_partner_fees', 'partner_net_selling_price', 'plateform_customer_discount', 'net_payment_price', 'received_amount'], 'number'],
            [['name', 'email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            ['start_date', 'date', 'format' => 'php:Y-m-d'],
            ['end_date', 'date', 'format' => 'php:Y-m-d'],
            ['end_date', 'compare', 'compareAttribute' => 'start_date', 'operator' => '>='],
            [['partner_selling_price'], 'integer', 'max' => 9999999],
            [['validity_date_time'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['permit_booking_date'], 'date', 'format' => 'php:Y-m-d'],
            [['validity_date_time'], 'validateTwoHourCondition'],
            [['permit_booking_date'],'compare', 'compareValue' => date("Y-m-d"), 'operator' => '>='],
            [['validity_date_time','permit_booking_date'], 'safe'],


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
            'safaris' => 'safaris',
            'travelers' => 'travelers',
            'stay_category_id' => 'Accomodation',
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
            'received_amount' => 'Recived Amount',
            'end_date' => 'End Date',
            'addtional_data' => 'Addtional Data',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'validity_date_time' => 'Validity Date Time',
            'permit_booking_date' => 'Permit Booking Date',
        ];
    }

    public function request($login_user)
    {

        $transaction = \Yii::$app->db->beginTransaction();
        try {

            $lead = Lead::find()->where(['id' => $this->lead_id])->one();

            $lpq = new LeadPartnerQuotes();
            $lpq->lead_partner_id = $this->lead_partner_id;
            $lpq->park_id = $this->park_id;
            $lpq->addional_notes = $this->addional_notes;
            $lpq->lead_id = $this->lead_id;
            $lpq->partner_id = $this->partner_id;
            $lpq->safaris = $this->safaris;
            $lpq->travelers = $this->travelers;
            $lpq->stay_category_id = $this->stay_category_id;
            $lpq->name = $lead->name ?? $this->name;
            $lpq->email = $lead->email ?? $this->email;
            $lpq->phone = $lead->phone ?? $this->phone;
            $lpq->start_date = $this->start_date;
            $lpq->partner_selling_price = $this->partner_selling_price;
            $lpq->plateform_partner_fees_percentage = $this->plateform_partner_fees_percentage;
            $lpq->plateform_partner_fees = $this->calculate_plateform_partner_fees();
            $lpq->partner_net_selling_price = $this->calculate_partner_net_selling_price();
            $lpq->plateform_customer_discount = $this->plateform_customer_discount;
            $lpq->net_payment_price = $this->calculate_net_payment_price();
            $lpq->installment = $this->installment;
            $lpq->received_amount = $this->received_amount;
            $lpq->end_date = $this->end_date;
            $lpq->addtional_data = $this->addtional_data;
            $lpq->validity_date_time = $this->validity_date_time;
            $lpq->permit_booking_date = $this->permit_booking_date;
            $lpq->status = 1;
            $lpq->save(false);

            $installment = new LeadPartnerQuoteInstallments();
            $installment->lead_partner_quote_id = $lpq->id;
            $installment->lead_id = $lpq->lead_id;
            $installment->partner_id = $lpq->partner_id;
            $installment->amount = $lpq->net_payment_price;
            $installment->payment_hash = Yii::$app->security->generateRandomString(10) . time() . Yii::$app->security->generateRandomString(5);
            $installment->before_datetime = $this->start_date;
            $installment->created_by = $login_user->id;
            $installment->updated_by = $login_user->id;
            $installment->save(false);

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            // If any exception occurs, rollback the transaction
            $transaction->rollBack();
            throw $e; // Re-throw the exception to handle it higher up
        }
    }

    private function calculate_plateform_partner_fees()
    {
        return round($this->partner_selling_price * $this->plateform_partner_fees_percentage / 100, 2);
    }
    private function calculate_partner_net_selling_price()
    {
        return $this->partner_selling_price + $this->calculate_plateform_partner_fees();
    }

    private function calculate_net_payment_price()
    {
        return $this->partner_selling_price + $this->calculate_plateform_partner_fees();
    }

    public function validateTwoHourCondition($attribute, $params)
    {
        $inputTime = strtotime($this->$attribute);
        $currentTime = time();
        $invalideTime = strtotime('+2 hours', $currentTime);

        if ($inputTime < $invalideTime) {
            $this->addError($attribute, 'The ' . $attribute . ' must be greater that 2 hours from current time.');
        }
    }
}
