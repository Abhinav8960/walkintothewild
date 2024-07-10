<?php

namespace common\models\article\category;

use common\models\article\Article;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**

 *
 * @property int $id
 * @property string $category
 * @property int $status
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class Category extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_category';
    }

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category', 'status'], 'required'],
            [['id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['category'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    // public function getArticles()
    // {
    //     return $this->hasMany(Article::class, ['id' => 'article_id'])
    //         ->viaTable('article_category', ['category_id' => 'id']);
    // }
}
