<?php

namespace api\models\transaction;

use api\models\leads\sharesafari\ShareSafariLead;
use api\models\meta\MetaStayCategory;
use api\models\operator\SafariOperator;
use api\models\park\SafariPark;
use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property string $reference_id
 * @property int $lead_partner_quotes_id
 * @property int $lead_partner_quote_installments_id
 * @property string $order_id
 * @property string $currency
 * @property int $lead_partner_id
 * @property int $lead_id
 * @property int $partner_id
 * @property int|null $park_id
 * @property string|null $addional_notes
 * @property int $safaris
 * @property int $travelers
 * @property int $stay_category_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string $start_date
 * @property string $end_date
 * @property string|null $validity_date
 * @property string|null $permit_booking_date
 * @property float $partner_selling_price
 * @property int $plateform_partner_fees_percentage %
 * @property float $plateform_partner_fees
 * @property float $partner_net_selling_price
 * @property float $plateform_customer_discount
 * @property float $net_payment_price
 * @property int $installment
 * @property float $received_amount
 * @property string|null $addtional_data
 * @property string|null $datetime_of_approval_by_admin
 * @property string|null $quotation_filepath
 * @property int $is_payment_received
 * @property string|null $transaction_datetime
 * @property int|null $payment_gateway     1=>payu,2=>icic,3=>hdfc
 * @property string $billing_name
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $billing_address
 * @property string|null $billing_city
 * @property string|null $billing_state
 * @property string|null $billing_zip
 * @property string|null $billing_country
 * @property string|null $billing_tel
 * @property string|null $billing_email
 * @property string|null $param1
 * @property string|null $param2
 * @property string|null $param3
 * @property string|null $param4
 * @property string|null $param5
 * @property int|null $status
 */
class Transaction extends \common\models\transaction\Transaction
{
    public function fields()
    {
        $fields = [
            'reference_id',
            // 'lead_partner_quotes_id',
            // 'lead_partner_quote_installments_id',
            'order_id',
            'currency',
            // 'lead',
            'partner', // relation
            'park', // relation
            'addional_notes',
            'safaris',
            'travelers',
            'Staycatgory', // relation
            'name',
            'email',
            'phone',
            'start_date',
            'end_date',
            'validity_date',
            'permit_booking_date',
            // 'partner_selling_price',
            // 'plateform_partner_fees_percentage',
            // 'plateform_partner_fees',
            // 'partner_net_selling_price',
            // 'plateform_customer_discount',
            'net_payment_price',
            // 'installment',
            'received_amount',
            // 'addtional_data',            
            'is_payment_received',
            'transaction_datetime',
            'payment_gateway',
        ];

        if ($this->source != self::SOURCE_SHARE_SAFARI) {
            $fields[] = 'share_safari_lead';
        }

        return $fields;
    }

    public function getPartner()
    {
        return $this->hasOne(SafariOperator::class, ['id' => 'partner_id']);
    }
    public function getPark()
    {
        return $this->hasOne(SafariPark::class, ['id' => 'park_id']);
    }

    public function getStaycatgory()
    {
        return $this->hasOne(MetaStayCategory::className(), ['id' => 'stay_category_id']);
    }

    public function getShare_safari_lead()
    {
        return $this->hasOne(ShareSafariLead::className(), ['id' => 'share_safari_lead_id']);
    }
}
