<?php

namespace common\models\compliancedocuments;

use Yii;

/**
 * This is the model class for table "compliance_documents_version".
 *
 * @property int $id
 * @property int $compliance_documents_id
 * @property string $version
 * @property string $description
 * @property int $is_live
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class ComplianceDocumentsVersion extends \yii\db\ActiveRecord 
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'compliance_documents_version';
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
            [['version'], 'default', 'value' => 'v1'],
            [['is_live'], 'default', 'value' => 0],
            [['compliance_documents_id', 'description', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'required'],
            [['compliance_documents_id', 'is_live', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['version'], 'string', 'max' => 255],
            [['compliance_documents_id', 'version'], 'unique', 'targetAttribute' => ['compliance_documents_id', 'version']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'compliance_documents_id' => 'Compliance Documents ID',
            'version' => 'Version',
            'description' => 'Description',
            'is_live' => 'Is Live',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

}
