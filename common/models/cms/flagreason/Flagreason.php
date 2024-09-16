<?php

namespace common\models\cms\flagreason;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "master_review_flag".
 *
 * @property string $reason
 * @property int $status
 */
class Flagreason extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_review_flag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reason'], 'required'],
            [['status'], 'integer'],
            [['reason'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reason' => 'Reason',
        ];
    }
}
