<?php

namespace common\models\operator;

use Yii;
use common\models\park\SafariPark;
use common\traits\CommanRelationship;
use common\models\meta\MetaStayCategory;
use common\models\operator\SafariOperator;
use common\models\User;

/**
 * This is the model class for table "operator_quote".
 *
 * @property int $id
 * @property int|null $safari_park_id
 * @property int|null $safaris
 * @property int|null $travelers
 * @property int|null $stay_category_id
 * @property string|null $full_name
 * @property string|null $email
 * @property string|null $phone_no
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $user_agent
 * @property string|null $ip_address
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class OperatorQuote extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operator_quote';
    }


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['safari_park_id', 'safaris', 'travelers', 'stay_category_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['full_name', 'email', 'start_date', 'end_date', 'user_agent'], 'string', 'max' => 255],
            [['phone_no'], 'string', 'max' => 12],
            [['ip_address'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'safari_park_id' => 'Safari Park',
            'safaris' => 'Safaris',
            'travelers' => 'Travelers',
            'stay_category_id' => 'Stay Category',
            'full_name' => 'Full Name',
            'email' => 'Email',
            'phone_no' => 'Phone No',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'user_agent' => 'User Agent',
            'ip_address' => 'Ip Address',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }


    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'safari_park_id']);
    }

    public function getOperator()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'operator_id']);
    }

    public function getStaycatgory()
    {
        return $this->hasOne(MetaStayCategory::className(), ['id' => 'stay_category_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
