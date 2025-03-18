<?php

namespace common\models\moderation;

use Yii;


class Moderation extends \common\models\moderation\ActiveRecord
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
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['type'], 'required'],
            [['type', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['text'], 'string'],
            [['video_url', 'image_url'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'video_url' => 'Video Url',
            'image_url' => 'Image Url',
            'text' => 'Text',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getModerationtext()
    {
        return $this->hasOne(ModerationText::className(), ['moderation_id' => 'id']);
    }
}
