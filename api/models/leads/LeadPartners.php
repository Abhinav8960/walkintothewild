<?php

namespace api\models\leads;

use api\models\operator\SafariOperator;
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
class LeadPartners extends \common\models\leads\LeadPartners
{
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
            [['lead_id', 'partner_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['lead_id', 'partner_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['lead_id', 'partner_id'], 'unique', 'targetAttribute' => ['lead_id', 'partner_id']],
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
        ];
    }

    public function getPartner()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'partner_id']);
    }


    public static function quotationCount($lead_id, $partner_id)
    {
        $count = LeadPartners::find()->where(['lead_id' => $lead_id, 'partner_id' => $partner_id])->limit(1)->one();
        if ($count && $count->quotation_count > 0) {
            return $count->quotation_count;
        }
        return 0;
    }

    public static function chatStarted($lead_id, $partner_id)
    {
        $start = LeadPartners::find()->where([
            'lead_id' => $lead_id,
            'partner_id' => $partner_id,
            'is_chat_started' => 1
        ])->limit(1)->one();

        if ($start) {
            return '<span class="badge badge-paid">Yes</span>';
        }
        return '<span class="badge badge-pending">No</span>';
    }
    
    public static function getReminder($id, $partner_id)
    {
        $reminder = LeadPartners::find()
            ->where(['lead_id' => $id, 'partner_id' => $partner_id])
            ->andWhere(['IS NOT', 'reminder_datetime', null])
            ->andWhere(['in', 'reminder_status', [0, 1]]) 
            ->orderBy(['reminder_status' => SORT_ASC])  
            ->one();
    
        if ($reminder) {
            if ($reminder->reminder_status == 0) {
                return '<span style="color: #ff0000; font-size: 22px; text-shadow: 0 0 8px #ff4d4d, 0 0 12px #ff1a1a;">●</span>';
            } elseif ($reminder->reminder_status == 1) {
                return '<span style="color: green; font-size: 22px; text-shadow: 0 0 8px rgb(14, 146, 64), 0 0 12px rgb(15, 116, 37);">●</span>';
            } else {
                return '<span style="color: grey; font-size: 22px; text-shadow: 0 0 8px rgb(102, 105, 103), 0 0 12px rgb(11, 12, 12);">●</span>';
            }
        }
        return '';
    }
    
}
