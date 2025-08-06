<?php

namespace common\models\leads\sharesafari;

use common\models\sharesafari\ShareSafari;
use Yii;

/**
 * This is the model class for table "share_safari_installment".
 *
 * @property int $id
 * @property int $share_safari_id
 * @property int $share_safari_user_id
 * @property int|null $share_safari_partner_id
 * @property int $version
 * @property int $type 1=>share safari, 2=> Fixed Departure
 * @property string|null $notes
 * @property int|null $user_id
 * @property string $name
 * @property string $email
 * @property float|null $amount
 * @property string|null $due_datetime
 * @property string|null $payment_link
 * @property string|null $payment_hash
 * @property int|null $transaction_id
 * @property int|null $payment_gateway 1=>payu,2=>icici
 * @property string|null $transaction_datetime
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int $status 0=>not received, 1=> received
 */
class ShareSafariLeadInstallment extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{

    public const STATUS_PENDING = 0;
    public const STATUS_SUCCESS = 1;
    public const STATUS_FAILED = 2;

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'share_safari_lead_installment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['share_safari_partner_id', 'notes', 'user_id', 'amount', 'due_datetime', 'payment_link', 'payment_hash', 'transaction_id', 'payment_gateway', 'transaction_datetime', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['share_safari_id', 'share_safari_user_id', 'version', 'type', 'name', 'email'], 'required'],
            [['share_safari_id', 'share_safari_user_id', 'share_safari_partner_id', 'version', 'type', 'user_id', 'transaction_id', 'payment_gateway', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'integer'],
            [['amount'], 'number'],
            [['due_datetime', 'transaction_datetime', 'installment', 'share_safari_lead_id'], 'safe'],
            [['notes', 'name', 'email', 'payment_link', 'payment_hash'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'share_safari_id' => 'Share Safari ID',
            'share_safari_user_id' => 'Share Safari User ID',
            'share_safari_partner_id' => 'Share Safari Partner ID',
            'version' => 'Version',
            'type' => 'Type',
            'notes' => 'Notes',
            'user_id' => 'User ID',
            'name' => 'Name',
            'email' => 'Email',
            'amount' => 'Amount',
            'due_datetime' => 'Due Datetime',
            'payment_link' => 'Payment Link',
            'payment_hash' => 'Payment Hash',
            'transaction_id' => 'Transaction ID',
            'payment_gateway' => 'Payment Gateway',
            'transaction_datetime' => 'Transaction Datetime',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    public function getShareSafariLead()
    {
        return $this->hasOne(ShareSafariLead::class, ['id' => 'share_safari_lead_id']);
    }

    public function getShareSafari()
    {
        return $this->hasOne(ShareSafari::class, ['id' => 'share_safari_id']);
    }
}
