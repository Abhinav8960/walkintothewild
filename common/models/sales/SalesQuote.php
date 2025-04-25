<?php

namespace common\models\sales;

use Yii;

/**
 * This is the model class for table "sales_quote".
 *
 * @property int $id
 * @property string $hash
 * @property int $is_package_quote
 * @property int $is_operator_quote
 * @property int $quotation_id
 * @property int $safari
 * @property int $travellers
 * @property int $stay_category_id
 * @property string $start_date
 * @property string $end_date
 * @property string $additional_notes
 * @property int $final_qoute
 * @property string $payment_link
 * @property int $is_payment_done
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class SalesQuote extends \yii\db\ActiveRecord
{

  public  $chat_hash;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
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
        return 'sales_quote';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_payment_done'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['hash', 'quotation_id', 'safari', 'travellers', 'stay_category_id', 'start_date', 'end_date', 'additional_notes', 'payment_link','chat_hash'], 'required'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
            [['is_package_quote', 'is_operator_quote', 'quotation_id', 'safari', 'travellers', 'stay_category_id', 'final_qoute', 'is_payment_done', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['additional_notes'], 'string'],
            [['hash', 'payment_link'], 'string', 'max' => 255],
            [['hash'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chat_hash' => 'chat hash',
            'hash' => 'Hash',
            'is_package_quote' => 'Is Package Quote',
            'is_operator_quote' => 'Is Operator Quote',
            'quotation_id' => 'Quotation ID',
            'safari' => 'Safari',
            'travellers' => 'Travellers',
            'stay_category_id' => 'Stay Category ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'additional_notes' => 'Additional Notes',
            'final_qoute' => 'Final Qoute',
            'payment_link' => 'Payment Link',
            'is_payment_done' => 'Is Payment Done',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function generateHash()
    {
        $this->hash = Yii::$app->security->generateRandomString(6) . time() . Yii::$app->security->generateRandomString(5);
    }
}
