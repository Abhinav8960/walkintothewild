<?php

namespace common\models\paymentgateway\payu;

use Yii;

/**
 * This is the model class for table "payment_payu_bearer_tokens".
 *
 * @property int $id
 * @property string $access_token
 * @property string $token_type
 * @property int $expires_in
 * @property string $expiry_datetime
 * @property string $scope
 * @property int $payu_created_at
 * @property int|null $created_at
 */
class PaymentPayuBearerTokens extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_payu_bearer_tokens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'default', 'value' => null],
            [['access_token', 'token_type', 'expires_in', 'expiry_datetime', 'scope',  'payu_created_at'], 'required'],
            [['expires_in', 'payu_created_at', 'created_at'], 'integer'],
            [['expiry_datetime'], 'safe'],
            [['access_token', 'token_type', 'scope',], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'access_token' => 'Access Token',
            'token_type' => 'Token Type',
            'expires_in' => 'Expires In',
            'expiry_datetime' => 'Expiry Datetime',
            'scope' => 'Scope',
            'payu_created_at' => 'Payu Created At',
            'created_at' => 'Created At',
        ];
    }

    public static function storeToken($arr)
    {
        $model = new self();
        $model->access_token = $arr['access_token'];
        $model->token_type = $arr['token_type'];
        $model->expires_in = $arr['expires_in'];
        $model->expiry_datetime = date('Y-m-d H:i:s', time() + $arr['expires_in']);
        $model->scope = $arr['scope'];
        $model->payu_created_at = $arr['created_at'];
        $model->created_at = time();
        return $model->save(false);
    }
}
