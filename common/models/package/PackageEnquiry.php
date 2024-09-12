<?php

namespace common\models\package;

use common\models\operator\SafariOperator;
use common\models\User;
use Yii;

/**
 * This is the model class for table "package_enquiry".
 *
 * @property int $id
 * @property int|null $safari_operator_id
 * @property int|null $package_id
 * @property int|null $user_id
 * @property int|null $no_of_travelers
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $name
 * @property string|null $email_address
 * @property string|null $phone
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class PackageEnquiry extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use \common\traits\CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'package_enquiry';
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
            [['safari_operator_id', 'package_id', 'user_id', 'no_of_travelers', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['name', 'email_address'], 'string', 'max' => 512],
            [['phone'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'safari_operator_id' => 'Safari Operator ID',
            'package_id' => 'Package ID',
            'user_id' => 'User ID',
            'no_of_travelers' => 'No Of Travelers',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'name' => 'Name',
            'email_address' => 'Email Address',
            'phone' => 'Phone',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getSafarioperator()
    {
        return $this->hasOne(SafariOperator::class, ['id' => 'safari_operator_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getPackage()
    {
        return $this->hasOne(Package::class, ['id' => 'package_id']);
    }
}
