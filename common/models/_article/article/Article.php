<?php

namespace common\models\article\article;

use common\traits\CommanRelationship;
use Yii;

/**
 * 
 *
 * @property int $id
 * @property string|null $article_title
 * @property string|null $writer
 * @property int|null $source
 * @property int|null $post_date
 * @property string|null $key_point
 * @property string|null $link
 * @property string|null $video
 * @property string|null $image
 * @property int|null $tag_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class Article extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_form';
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
            [['video', 'image', 'link'], 'safe'],
            [['article_title', 'writer','link','video','image'], 'string', 'max' => 255],
            ['post_date', 'date', 'format' => 'php:Y-m-d'],
            [['tag_id'], 'safe'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by','source','post_date'], 'integer'],
            [['key_point'], 'validateMaxWords', 'params' => ['max' => 500]],
        ];
    }
    public function validateMaxWords($attribute, $params)
    {
        $maxWords = $params['max'];
        $wordCount = str_word_count($this->$attribute);
        if ($wordCount > $maxWords) {
            $this->addError($attribute, "The $attribute must not exceed $maxWords words.");
        }
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_title' => 'Article Title',
            'writer' => 'Writer',
            'link' => 'Link',
            'video' => 'Video',
            'image' => 'Image',
            'tag_id' => 'Tag',
            'source' => 'Source',
            'post_date' => 'Post Date',
            'key_point' => 'Abstract',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getImagepath()
    {
        if ($this->image != '') {
            return '/storage/article/' . $this->id . '/' . $this->image;
        }
    }
    public function getVideopath()
    {
        if ($this->video != '') {
            return '/storage/article/' . $this->id . '/' . $this->video;
        }
    }
}
