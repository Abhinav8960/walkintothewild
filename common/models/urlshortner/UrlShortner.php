<?php

namespace common\models\urlshortner;

use Yii;

/**
 * This is the model class for table "url_shortner".
 *
 * @property int $id
 * @property string $shortner_url
 * @property string $short_id
 * @property int $code
 * @property string|null $alias
 * @property int|null $created_at
 */
class UrlShortner extends \yii\db\ActiveRecord
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
        return 'url_shortner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'default', 'value' => 302],
            [['shortner_url', 'short_id'], 'required'],
            [['shortner_url'], 'string'],
            [['code', 'created_at'], 'integer'],
            [['short_id', 'alias'], 'string', 'max' => 10],
            [['short_id'], 'unique'],
            [['click_count'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shortner_url' => 'Shortner Url',
            'short_id' => 'Short ID',
            'code' => 'Code',
            'alias' => 'Alias',
            'created_at' => 'Created At',
        ];
    }

    public function incrementClick()
    {
        $this->updateCounters(['click_count' => 1]);
    }
}
