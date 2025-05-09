<?php

namespace api\models\leads;

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

}