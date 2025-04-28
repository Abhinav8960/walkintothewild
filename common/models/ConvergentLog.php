<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "convergent_log".
 *
 * @property int $id
 * @property string $phone
 * @property string|null $case_id
 * @property string|null $response
 * @property string|null $timestamp
 * @property string|null $token_used
 */
class ConvergentLog extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'convergent_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['case_id', 'response', 'timestamp', 'token_used'], 'default', 'value' => null],
            [['phone'], 'required'],
            [['response'], 'string'],
            [['timestamp'], 'safe'],
            [['phone', 'case_id', 'token_used'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone',
            'case_id' => 'Case ID',
            'response' => 'Response',
            'timestamp' => 'Timestamp',
            'token_used' => 'Token Used',
        ];
    }

}