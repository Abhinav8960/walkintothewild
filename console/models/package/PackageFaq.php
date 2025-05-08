<?php

namespace console\models\package;

use Yii;

/**
 * This is the model class for table "package_faq".
 *
 * @property int $id
 * @property int $package_id
 * @property string|null $question
 * @property string|null $answer
 * @property int|null $position
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class PackageFaq extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use \common\traits\CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pp_package_faq';
    }

     

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
            [['package_id'], 'required'],
            [['package_id', 'position', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['answer'], 'string'],
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
            'package_id' => 'Package ID',
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
