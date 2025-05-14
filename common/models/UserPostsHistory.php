<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_posts_history".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $version
 * @property int|null $user_id
 * @property int|null $safari_operator_id
 * @property string|null $file
 * @property string|null $thumbnail
 * @property string|null $filepath
 * @property string|null $etag
 * @property int|null $size
 * @property string|null $caption
 * @property int|null $height
 * @property int|null $width
 * @property string|null $delete_reason
 * @property int $status
 * @property int|null $total_view
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class UserPostsHistory extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_posts_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'safari_operator_id', 'file', 'thumbnail', 'filepath', 'etag', 'size', 'caption', 'height', 'width', 'delete_reason', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['total_view'], 'default', 'value' => 0],
            [['parent_id'], 'required'],
            [['parent_id', 'version', 'user_id', 'safari_operator_id', 'size', 'height', 'width', 'status', 'total_view', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['caption'], 'string'],
            [['file', 'thumbnail', 'filepath', 'etag'], 'string', 'max' => 255],
            [['delete_reason'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'version' => 'Version',
            'user_id' => 'User ID',
            'safari_operator_id' => 'Safari Operator ID',
            'file' => 'File',
            'thumbnail' => 'Thumbnail',
            'filepath' => 'Filepath',
            'etag' => 'Etag',
            'size' => 'Size',
            'caption' => 'Caption',
            'height' => 'Height',
            'width' => 'Width',
            'delete_reason' => 'Delete Reason',
            'status' => 'Status',
            'total_view' => 'Total View',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}