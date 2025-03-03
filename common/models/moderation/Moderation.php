<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "moderation".
 *
 * @property int $id
 * @property string $request_id
 * @property int $request_timestamp
 * @property string $moderation_type
 */
class Moderation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'moderation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_id', 'request_timestamp', 'moderation_type'], 'required'],
            [['request_id', 'moderation_type','request_timestamp'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'request_id' => 'Request ID',
            'request_timestamp' => 'Request Timestamp',
            'moderation_type' => 'Moderation Type',
        ];
    }

}