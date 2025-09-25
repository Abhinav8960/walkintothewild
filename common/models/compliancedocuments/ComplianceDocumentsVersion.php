<?php

namespace common\models\compliancedocuments;

use common\models\User;
use Yii;

/**
 * This is the model class for table "compliance_documents_version".
 *
 * @property int $id
 * @property int|null $type 1 => Privacy Policy
 2 => Terms and Conditions,
 3 => Refund Policy,
 4 => Other
 * @property int|null $version
 * @property string|null $content
 * @property string|null $effective_date
 * @property int $created_at
 * @property int $created_by
 */
class ComplianceDocumentsVersion extends \yii\db\ActiveRecord
{

    const STATUS_PUBLISHED = 1;
    const STATUS_UNPUBLISHED = 0;

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
            [['content', 'effective_date', 'compliance_documents_id'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['created_at', 'created_by'], 'required'],
            [['type', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['content', 'version'], 'string'],
            [['effective_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'compliance_documents_id' => 'Compliance Documents Id',
            'type' => 'Type',
            'version' => 'Version',
            'content' => 'Content',
            'effective_date' => 'Effective Date',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'Updated_by' => 'Updated By'
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public static function compliancedocumenttype($type)
    {
        $compliance_document = [
            1 => 'Privacy Policy',
            2 => 'Terms and Conditions',
            3 => 'Refund Policy',
            4 => 'Other',
        ];
        return $compliance_document[$type] ?? '';
    }

    public function getStatuslabel()
    {
        if ($this->status == 1) {
            return "Published";
        } else {
            return "Unpublished";
        }
        return $this->status;
    }
}
