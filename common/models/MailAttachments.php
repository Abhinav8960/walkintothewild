<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mail_attachments".
 *
 * @property int $id
 * @property int $mail_log_id
 * @property int $source_file_system 1=>fs,2=>rfs
 * @property string|null $file_name
 * @property string|null $file_path
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class MailAttachments extends \common\models\trierror\ActiveLogRecord implements \common\interfaces\NewStatusInterface
{

    const SOURCE_FILE_SYSTEM_FS = 1; // File System
    const SOURCE_FILE_SYSTEM_RFS = 2; // Remote File System

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mail_attachments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_name', 'file_path', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['mail_log_id', 'source_file_system'], 'required'],
            [['mail_log_id', 'source_file_system', 'created_at', 'updated_at'], 'integer'],
            [['file_name', 'file_path'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mail_log_id' => 'Mail Log ID',
            'source_file_system' => 'Source File System',
            'file_name' => 'File Name',
            'file_path' => 'File Path',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getFilepath()
    {
        if ($this->source_file_system == self::SOURCE_FILE_SYSTEM_FS) {
            return \Yii::$app->params['s3_endpoint'] . '/' . $this->file_path;
        } elseif ($this->source_file_system == self::SOURCE_FILE_SYSTEM_RFS) {
            $expiresAt = new \DateTimeImmutable("+2 minutes");
            $url = Yii::$app->rfs->temporaryUrl($this->file_path, $expiresAt);
        }
        return null;
    }
}
