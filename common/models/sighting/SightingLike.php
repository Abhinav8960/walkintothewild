<?php

namespace common\models\sighting;

use common\traits\CommanRelationship;
use Yii;


class SightingLike extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sighting_like';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['user_id', 'sighting_id'], 'required'],
            [['user_id', 'sighting_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'safari_operator_id'], 'integer'],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'sighting_id' => 'Sighting ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }


    public function afterSave($insert, $changedAttributes)
    {
        $this->updateSightingLikeCount();
        parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        $this->updateSightingLikeCount();
        parent::afterDelete();
    }

    public function updateSightingLikeCount()
    {
        if ($this->sighting_id) {
            $sighting = Sighting::find()->where(['status' => Sighting::STATUS_ACTIVE, 'id' => $this->sighting_id])->one();
            $likes_count = SightingLike::find()->where(['sighting_id' => $this->sighting_id, 'status' => SightingLike::STATUS_ACTIVE])->count();
            if ($sighting) {
                $sighting->like_count = $likes_count;
                $sighting->save(false);
            }
        }
    }
}
