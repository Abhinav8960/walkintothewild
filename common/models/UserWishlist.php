<?php

namespace common\models;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "user_wishlist".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $item_id
 * @property int|null $item_type_id
 * @property string|null $item_type
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class UserWishlist extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;

    const SAFARI_PACKAGE = 1;
    const SHARED_SAFARI = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_wishlist';
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
            [['user_id','item_type_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['item_type','item_id'], 'string', 'max' => 255],
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
            'item_id' => 'Item ID',
            'item_type_id' => 'Item Type ID',
            'item_type' => 'Item Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
