<?php

namespace common\models\package;

use Yii;

/**
 * This is the model class for table "package_feature".
 *
 * @property int $id
 * @property int $package_id
 * @property int $feature_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $updated_at
 */
class PackageFeature extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'package_feature';
    }

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
            [['package_id', 'feature_id'], 'required'],
            [['package_id', 'feature_id', 'status', 'created_at', 'created_by', 'updated_by', 'updated_at'], 'integer'],
            [['feature_id', 'package_id'], 'unique', 'targetAttribute' => ['feature_id', 'package_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'package_id' => 'Package ID',
            'feature_id' => 'Feature ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }
}
