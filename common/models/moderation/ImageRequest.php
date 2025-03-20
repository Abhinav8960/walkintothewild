<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "image_request".
 *
 * @property int $id
 * @property int|null $moderation_id
 * @property string|null $media_id
 * @property float|null $timestamp
 * @property float|null $operations
 */
class ImageRequest extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_request';
    }

    public static function getDb()
    {
        return Yii::$app->get('db_moderation');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['moderation_id', 'media_id', 'timestamp', 'operations'], 'default', 'value' => null],
            [['id'], 'required'],
            [['id', 'moderation_id'], 'integer'],
            [['timestamp', 'operations'], 'number'],
            [['media_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'moderation_id' => 'Moderation ID',
            'media_id' => 'Media ID',
            'timestamp' => 'Timestamp',
            'operations' => 'Operations',
        ];
    }

    public static function requestStore($feedback, $moderationId)
    {
        // if (!isset($feedback['request']) || !is_array($feedback['request'])) {
        //     return false;
        // }

        // print_r($feedback['request']['id']);
        // die('requestStore');

        $model = new self();
        $model->moderation_id = $moderationId;
        $model->media_id = $feedback['media']['id'] ?? null;
        $model->request_id = $feedback['request']['id'] ?? null;
        $model->timestamp = $feedback['request']['timestamp'] ?? null;
        $model->operations = $feedback['request']['operations'] ?? 0;

        if (!$model->save()) {
            return false;
        }

        return true;
    }
}
