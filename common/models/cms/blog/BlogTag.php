<?php

namespace common\models\cms\blog;

use Yii;

/**
 * This is the model class for table "blog_tag".
 *
 * @property int $id
 * @property int $blog_id
 * @property int $master_blog_tag_id
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class BlogTag extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use \common\traits\CommanRelationship;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog_tag';
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['blog_id', 'master_blog_tag_id'], 'required'],
            [['blog_id', 'master_blog_tag_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['blog_id', 'master_blog_tag_id'], 'unique', 'targetAttribute' => ['blog_id', 'master_blog_tag_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'blog_id' => 'Blog ID',
            'master_blog_tag_id' => 'Master Blog Tag ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getBlogtag()
    {
        return $this->hasOne(MasterBlogTag::className(), ['id' => 'master_blog_tag_id']);
    }
}
