<?php

namespace common\models\cms\blog;

use common\models\cms\mastercategory\MasterTopic;
use Yii;

/**
 * This is the model class for table "blog_topic".
 *
 * @property int $id
 * @property int $blog_id
 * @property int $master_topic_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class BlogTopic extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use \common\traits\CommanRelationship;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog_topic';
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
            [['blog_id', 'master_topic_id'], 'required'],
            [['id', 'blog_id', 'master_topic_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['blog_id', 'master_topic_id'], 'unique', 'targetAttribute' => ['blog_id', 'master_topic_id']],
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
            'master_topic_id' => 'Master Blog Topic ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getBlogname()
    {
        return $this->hasOne(MasterTopic::class, ['id' => 'master_topic_id']);
    }
}
