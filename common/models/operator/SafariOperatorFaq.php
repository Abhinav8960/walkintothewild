<?php

namespace common\models\operator;

use common\models\GeneralModel;
use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "safari_operator_faq".
 *
 * @property int $id
 * @property int|null $safari_oparator_id
 * @property int|null $package_id
 * @property int|null $share_safari_id
 * @property string|null $question
 * @property string|null $answer
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class SafariOperatorFaq extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{

    use CommanRelationship;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'safari_operator_faq';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['safari_operator_id','question', 'answer', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['safari_oparator_id', 'sequence', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['question', 'answer'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'safari_operator_id' => 'Safari Oparator ID',
            'question' => 'Question',
            'answer' => 'Answer',
            'status' => 'Status',
            'sequence'=>'Sequence',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

}
