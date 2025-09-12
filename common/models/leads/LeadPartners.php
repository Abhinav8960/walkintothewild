<?php

namespace common\models\leads;

use common\models\operator\SafariOperator;
use Yii;

/**
 * This is the model class for table "lead_partners".
 *
 * @property int $id
 * @property int $lead_id
 * @property int $partner_id safari_operator
 * @property int $status
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 */
class LeadPartners extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{

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
        return 'lead_partners';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 1],
            [['transaction_datetime', 'payment_gateway'], 'safe'],
            [['lead_id', 'partner_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['lead_id', 'partner_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at', 'is_payment_received', 'transaction_id'], 'integer'],
            [['lead_id', 'partner_id'], 'unique', 'targetAttribute' => ['lead_id', 'partner_id']],
            [['reminder_datetime','reminder_status'],'safe'],
            [['reminder_status'],'integer'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lead_id' => 'Lead ID',
            'partner_id' => 'Partner ID',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',


            'reminder_datetime' => 'Reminder Datetime',
            'reminder_status' => 'Reminder Status',
        ];
    }

    public function getPartner()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'partner_id']);
    }
}
