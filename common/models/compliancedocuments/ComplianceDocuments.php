<?php

namespace common\models\compliancedocuments;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "compliance_documents".
 *
 * @property int $id
 * @property string $uuid
 * @property string|null $title
 * @property string|null $policy_for
 * @property string|null $effective_from
 * @property string|null $description
 * @property string|null $version
 * @property int $status 1 => Active , 0 => Suspended
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class ComplianceDocuments extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'compliance_documents';
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
            [['title', 'policy_for', 'effective_from', 'description', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['version'], 'string', 'max' => 10],
            [['effective_from','uuid','version'], 'safe'],
            [['description','uuid','version'], 'string'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'policy_for' => 'Policy For',
            'effective_from' => 'Effective From',
            'description' => 'Description',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
   
}
