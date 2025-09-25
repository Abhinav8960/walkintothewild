<?php

namespace common\models\compliancedocuments;

use common\models\GeneralModel;
use common\models\User;
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
 * @property string|null $effective_to
 *  @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property int $status 1 => Active , 0 => Suspended
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class ComplianceDocuments extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;

    const STATUS_CREATE = 10;
    const STATUS_PUBLISHED = 1;
    const STATUS_UNPUBLISHED = 0;

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
            [['content', 'effective_date'], 'default', 'value' => null],
            [['type'], 'default', 'value' => 0],
            [['type', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['content', 'version'], 'string'],
            [['effective_date'], 'safe'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'compliance_documents_version_id' => 'Compliance Documents Version ID',
            'type' => 'Type',
            'version' => 'Version',
            'content' => 'Content',
            'effective_date' => 'Effective Date',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    // public function getVersions()
    // {
    //     return $this->hasMany(ComplianceDocumentsVersion::class, ['compliance_documents_id' => 'id']);
    // }

    // public function getLatestVersion()
    // {
    //     return $this->getVersions()->orderBy(['id' => SORT_DESC])->one();
    // }

    // public function getVersiondata()
    // {
    //     return $this->hasOne(ComplianceDocumentsVersion::class, ['compliance_documents_id' => 'id']);
    // }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
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
