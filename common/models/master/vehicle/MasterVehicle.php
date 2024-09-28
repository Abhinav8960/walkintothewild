<?php

namespace common\models\master\vehicle;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "master_vehicle".
 *
 * @property int $id
 * @property string $vehicle_name
 * @property string|null $icon
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class MasterVehicle extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_vehicle';
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
            [['vehicle_name'], 'required'],
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['vehicle_name', 'icon'], 'string', 'max' => 125],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vehicle_name' => 'Vehicle Name',
            'icon' => 'Icon',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }


    public function getImagepath()
    {
        if ($this->icon != '') {
            return '/storage/vehicle/' . $this->id . '/' . $this->icon;
        }
    }

    /** After record is saved
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $className = substr(get_class($this), strrpos(get_class($this), '\\') + 1);
        \common\models\MasterMetaTableInfo::upsert($className, SELF::find()->where(['status'=>SELF::STATUS_ACTIVE])->count(), date('Y-m-d H:i:s', SELF::find()->max('updated_at')));
        return  true;
    }
}
