<?php

namespace common\models\master\broadcast;

use Yii;

/**
 * This is the model class for table "master_channel_template".
 *
 * @property int $id
 * @property string $channel
 * @property string $template
 * @property string|null $name
 * @property string|null $path
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class MasterChannelTemplate extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_channel_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'path', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['channel', 'template'], 'required'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['channel', 'template', 'name', 'path'], 'string', 'max' => 255],
            [['channel', 'template'], 'unique', 'targetAttribute' => ['channel', 'template']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel' => 'Channel',
            'template' => 'Template',
            'name' => 'Name',
            'path' => 'Path',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

}