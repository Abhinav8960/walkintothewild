<?php

namespace common\models\compliancedocuments;

use common\models\User;
use Yii;

/**
 * This is the model class for table "compliance_documents_version".
 *
 * @property int $id
 * @property string|null $title
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
            [['content', 'effective_date'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['created_at', 'created_by'], 'required'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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

    public function getStatuslabel()
    {
        if ($this->status == 1) {
            return "Published";
        } else {
            return "Unpublished";
        }
        return $this->status;
    }

    public function getLabeltype(){
        if($this->type == 1){
            return "Terms and Conditions";
        }
        elseif($this->type == 2){
            return "Privacy Policy";
        }
        else{
            return "";
        }
    }
}
