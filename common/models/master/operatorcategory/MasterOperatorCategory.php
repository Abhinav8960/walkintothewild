<?php

namespace common\models\master\operatorcategory;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "master_operator_category".
 *
 * @property int $id
 * @property string|null $title
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class MasterOperatorCategory extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{

    const TYPE_SAFARI = 1;
    const TYPE_BIRDING = 2;

    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_operator_category';
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
            [['status', 'type_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
            'type_id' => 'Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public static function OperatorCategoryType(){

        return [
            SELF::TYPE_SAFARI => 'Safari',
            SELF::TYPE_BIRDING => 'Birding'
        ];
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
