<?php

namespace common\models\sharesafari;

use Yii;

/**
 * This is the model class for table "share_safari_included".
 *
 * @property int $id
 * @property int $share_safari_id
 * @property int $include_id
 * @property int|null $selection
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $updated_at
 */
class ShareSafariIncluded extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'share_safari_included';
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
            [['share_safari_id', 'include_id'], 'required'],
            [['share_safari_id', 'include_id', 'selection', 'status', 'created_at', 'created_by', 'updated_by', 'updated_at'], 'integer'],
            [['share_safari_id', 'include_id','version'], 'unique', 'targetAttribute' => ['share_safari_id', 'include_id']],
            [['version'],'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'share_safari_id' => 'Share Safari ID',
            'include_id' => 'Include ID',
            'selection' => 'Selection',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }
}
