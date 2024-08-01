<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "auth_temp".
 *
 * @property int $id
 * @property string $rand_key
 * @property string|null $username
 * @property string|null $gmail
 * @property string|null $email
 * @property string|null $source
 * @property string|null $source_id
 * @property int $status
 * @property string $created_at
 */
class AuthTemp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_temp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rand_key'], 'required'],
            [['status'], 'integer'],
            [['created_at'], 'safe'],
            [['rand_key'], 'string', 'max' => 255],
            [['username', 'gmail', 'email', 'source', 'source_id'], 'string', 'max' => 555],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rand_key' => 'Rand Key',
            'username' => 'Username',
            'gmail' => 'Gmail',
            'email' => 'Email',
            'source' => 'Source',
            'source_id' => 'Source ID',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
