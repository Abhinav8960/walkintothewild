<?php

namespace common\models\article\articleSource;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "deployment_phase".
 *
 *  @property int $id
 * @property string|null $article_source
 * @property string|null $publisher 
 * @property string|null $web_link
 * @property int|null $category_id
 * @property int|null $frequency_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class ArticleSource extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_source';
    }



    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
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
            [['article_source','publisher','web_link'], 'string', 'max' => 255],

            [['category_id','frequency_id','status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_source' => 'Article Source',
            'category_id' => 'Category',
            'publisher' => 'Publisher',
            'frequency_id' => 'Frequency',
            'web_link' => 'Web Links',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
