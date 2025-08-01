<?php

namespace common\models\sharesafari;

use Yii;

/**
 * This is the model class for table "share_safari_faq".
 *
 * @property int $id
 * @property int $share_safari_id
 * @property int|null $faq_id
 * @property string|null $question
 * @property string|null $answer
 * @property int|null $position
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class ShareSafariFaq extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use \common\traits\CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'share_safari_faq';
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
            [['share_safari_id'], 'required'],
            [['share_safari_id', 'faq_id', 'position', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['answer'], 'string'],
            [['question'], 'string', 'max' => 512],
            [['master_faq_id','version'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'share_safari_id' => 'Share Safari ID',
            'faq_id' => 'Faq ID',
            'question' => 'Question',
            'answer' => 'Answer',
            'position' => 'Position',
            'master_faq_id' => 'Master Faq Id',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
