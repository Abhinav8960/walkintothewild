<?php

namespace common\models\park;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "safari_park_gallery".
 *
 * @property int $id
 * @property int $safari_park_id
 * @property string|null $image
 * @property string|null $image_caption
 * @property int $sequence
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class SafariParkGallery extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'safari_park_gallery';
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
            // [['safari_park_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'required'],
            [['safari_park_id', 'sequence', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['image', 'image_caption'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'safari_park_id' => 'Safari Park ID',
            'image' => 'Image',
            'image_caption' => 'Image Caption',
            'sequence' => 'Sequence',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getImagepath()
    {
        if ($this->image != '') {
            return '/storage/safariparkgallery/' . $this->id . '/' . $this->image;
        }
    }
}
