<?php

namespace common\models\cms\article;

use Yii;

/**
 * This is the model class for table "article_author".
 *
 * @property int $id
 * @property int $article_id
 * @property string $author_name
 * @property string $slug
 * @property string|null $author_image
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $updated_at
 * @property int|null $status
 */
class ArticleAuthor extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use \common\traits\CommanRelationship;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_author';
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
            [
                'class' => \yii\behaviors\SluggableBehavior::class,
                'attribute' => 'author_name',
                'slugAttribute' => 'slug',
                'immutable' => true,
                'ensureUnique' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_name', 'slug'], 'required'],
            [['created_at', 'created_by', 'updated_by', 'updated_at', 'status'], 'integer'],
            [['author_name', 'author_image'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_name' => 'Author Name',
            'slug' => 'Slug',
            'author_image' => 'Author Image',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
