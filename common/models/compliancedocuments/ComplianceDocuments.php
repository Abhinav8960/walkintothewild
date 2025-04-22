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
 * @property string|null $effective_form
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'policy_for', 'effective_form', 'description', 'version', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['uuid'], 'required'],
            [['effective_form'], 'safe'],
            [['description'], 'string'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['uuid', 'title', 'policy_for', 'version'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uuid' => 'Uuid',
            'title' => 'Title',
            'policy_for' => 'Policy For',
            'effective_form' => 'Effective Form',
            'description' => 'Description',
            'version' => 'Version',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ComplianceDocumentsQuery the active query used by this AR class.
     */
   

}
