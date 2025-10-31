<?php

namespace common\models\userprivacypolicyacknowledgement;

use common\models\compliancedocuments\ComplianceDocuments;
use common\models\User;
use Yii;

/**
 * This is the model class for table "user_privacy_policy_acknowledgement".
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $user_id
 * @property string|null $document_version
 * @property int|null $document_id
 */
class UserPrivacyPolicyAcknowledgement extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_privacy_policy_acknowledgement';
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::class,
            \yii\behaviors\BlameableBehavior::class,
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uuid', 'user_id', 'document_version', 'document_id'], 'default', 'value' => null],
            [['user_id', 'document_id', 'created_at', 'created_by','updated_at' ,'updated_by'], 'integer'],
            [['uuid', 'document_version'], 'string', 'max' => 255],
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
            'user_id' => 'User ID',
            'document_version' => 'Document Version',
            'document_id' => 'Document ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getDocument()
    {
        return $this->hasOne(ComplianceDocuments::class, ['id' => 'document_id']);
    }

}
