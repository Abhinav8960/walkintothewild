<?php

namespace common\models\package;

use common\models\User;
use Yii;

/**
 * This is the model class for table "package_comment".
 *
 * @property int $id
 * @property int|null $package_id
 * @property int|null $parent_id
 * @property int|null $user_id
 * @property string|null $comment
 * @property int $flaged
 * @property string|null $user_device
 * @property string|null $user_agent
 * @property string|null $user_platform
 * @property string|null $user_browser
 * @property string|null $user_ip_address
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class PackageComment extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use \common\traits\CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'package_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['package_id', 'parent_id', 'user_id', 'flaged', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['comment'], 'string'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'package_id' => 'Package ID',
            'parent_id' => 'Parent ID',
            'user_id' => 'User ID',
            'comment' => 'Comment',
            'flaged' => 'Flaged',
            'user_device' => 'User Device',
            'user_agent' => 'User Agent',
            'user_platform' => 'User Platform',
            'user_browser' => 'User Browser',
            'user_ip_address' => 'User Ip Address',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    public function getReplies()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getPackage()
    {
        return $this->hasOne(Package::className(), ['id' => 'package_id']);
    }


    public function getReports()
    {
        return $this->hasMany(PackageCommentReport::className(), ['package_comment_id' => 'id']);
    }
}
