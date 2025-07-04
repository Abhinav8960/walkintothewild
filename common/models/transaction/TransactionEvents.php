<?php

namespace common\models\transaction;

use Yii;

/**
 * This is the model class for table "transaction_events".
 *
 * @property int $id
 * @property int $transaction_id
 * @property int $event
 * @property string $event_datetime
 * @property int $created_at
 * @property int $updated_at
 */
class TransactionEvents extends \yii\db\ActiveRecord
{

    public const EVENT_CART_OPEN = 1;
    public const EVENT_PAYMENT_INITIATED = 2;
    public const EVENT_PAYMENT_STATUS_SUCCESS = 3;
    public const EVENT_PAYMENT_STATUS_FAILED = 4;
    public const EVENT_PAYMENT_STATUS_PAGE_OPEN = 5;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [

            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction_events';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transaction_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['lead_partner_quote_id', 'event', 'event_datetime'], 'required'],
            [['lead_partner_quote_id', 'transaction_id', 'event', 'created_at', 'updated_at'], 'integer'],
            [['event_datetime'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lead_partner_quote_id' => 'Lead Partner Quote ID',
            'transaction_id' => 'Transaction ID',
            'event' => 'Event',
            'event_datetime' => 'Event Datetime',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getEventLabel()
    {

        $arr =  [
            self::EVENT_CART_OPEN => 'Cart Open',
            self::EVENT_PAYMENT_INITIATED => 'Payment initiated',
            self::EVENT_PAYMENT_STATUS_SUCCESS => 'Payment Success',
            self::EVENT_PAYMENT_STATUS_FAILED => 'Payment Failed',
            self::EVENT_PAYMENT_STATUS_PAGE_OPEN => 'Payment Status Page Open'
        ];
        return $arr[$this->event] ?? 'N/A';
    }

    public static function store($event, $quote_id, $transaction_id = null)
    {
        $m  = new self();
        $m->lead_partner_quote_id = $quote_id;
        $m->transaction_id = $transaction_id;
        $m->event = $event;
        $m->event_datetime = date('Y-m-d H:i:s');
        return $m->save(false);
    }
}
