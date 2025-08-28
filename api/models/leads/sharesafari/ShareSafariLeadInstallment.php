<?php

namespace api\models\leads\sharesafari;

use api\models\sharesafari\ShareSafari;
use Yii;

class ShareSafariLeadInstallment extends \common\models\leads\sharesafari\ShareSafariLeadInstallment 
{

    public function fields()
    {
        $fields = [
            // 'id',
            // 'share_safari_id',
            // 'share_safari_user_id',
            // 'share_safari_partner_id',
            // 'version',
            'type'=> function () {
                return $this->type == 1 ? 'Share Safari' : 'Fixed Departure';
            },
            // 'notes',
            // 'user_id',
            // 'name',
            // 'email',
            'amount',
            // 'due_datetime',
            // 'payment_link',
            'payment_hash',
            // 'transaction_id',
            // 'payment_gateway',
            // 'transaction_datetime',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',
            // 'status',
        ];

        if($this->type == 2){
            $fields['web_url'] =  function () {
                return Yii::$app->params['frontend_url_for_payments'] . '/safari-payment/' . $this->shareSafari->payment_hash;
            };
        }


        return $fields;
    }

    public function getShareSafari()
    {
        return $this->hasOne(ShareSafari::class, ['id' => 'share_safari_id']);
    }





}