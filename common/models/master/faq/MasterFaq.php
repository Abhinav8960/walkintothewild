<?php

namespace common\models\master\faq;

use Yii;

/**
 * This is the model class for table "master_faq".
 *
 * @property int $id
 * @property string|null $question
 * @property string|null $answer
 * @property int $position
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class MasterFaq extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_faq';
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
            [['answer'], 'string'],
            [['position', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['question'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Question',
            'answer' => 'Answer',
            'position' => 'Position',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
