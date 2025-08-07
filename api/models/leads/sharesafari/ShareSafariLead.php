<?php

namespace api\models\leads\sharesafari;

use common\models\GeneralModel;
use api\models\leads\sharesafari\ShareSafariLeadInstallment;
use api\models\User;
use Yii;


class ShareSafariLead extends \common\models\leads\sharesafari\ShareSafariLead
{

    public function fields()
    {
        return [
            // 'id',
            // 'share_safari_id',
            // 'share_safari_user_id',
            // 'share_safari_partner_id',
            // 'version',
            // 'type',
            'seat' => function () {
                return $this->quantity;
            },
            'notes',
            // 'user_id',
            'name',
            'email',
            'phone',
            'profile_display_image' => function () {
                return $this->user->profile_display_image ?? null;
            },
            'start_date' => function () {
                return $this->start_date ? date('Y-m-d', strtotime($this->start_date)) : null;
            },
            'end_date' => function () {
                return $this->end_date ? date('Y-m-d', strtotime($this->end_date)) : null;
            },
            'gross_price',
            'discount',
            'net_price',
            'cost_per_quantity',
            'payment_details',
            'collection' => function () {
                return $this->collection;
                // return $this->collection != null ? json_decode($this->collection, true) : [];
            },
            // 'status',
        ];
    }

    public function getPayment_details()
    {
        // return $this->hasOne(ShareSafariLeadInstallment::class, ['share_safari_lead_id' => 'id'])-->andWhere(['is_payment_received' => 1]);
        return $this->hasOne(ShareSafariLeadInstallment::class, ['share_safari_lead_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    // public function getPaymentDetails()
    // {
    //     return [
    //         'cost_per_quantity' => $this->cost_per_quantity,
    //         'received_amount' => $this->received_amount,
    //         'is_payment_received' => $this->is_payment_received,
    //         'payment_receipt' => $this->payment_receipt,
    //         'transaction_datetime' => $this->transaction_datetime,
    //         'payment_gateway' => $this->payment_gateway,
    //         'is_payment_expired' => $this->is_payment_expired,
    //     ];
    // }
}
