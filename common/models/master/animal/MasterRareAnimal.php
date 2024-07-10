<?php

namespace common\models\master\animal;

use Yii;
use common\traits\CommanRelationship;
use common\models\park\SafariParkRareAnimal;

/**
 * This is the model class for table "master_rare_animal".
 *
 * @property int $id
 * @property string|null $animal_name
 * @property string|null $banner
 * @property string|null $feature_image
 * @property string|null $know_as
 * @property string|null $short_description
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class MasterRareAnimal extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_rare_animal';
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
            'slug' => [
                'class' => 'skeeks\yii2\slug\SlugBehavior',
                'slugAttribute' => 'slug', //The attribute to be generated
                'attribute' => 'animal_name', //The attribute from which will be generated
                'maxLength' => 255,
                'ensureUnique' => true,
                'slugifyOptions' => [
                    'lowercase' => true,
                    'separator' => '-',
                    'trim' => true
                ]
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_feature_sequence'], 'integer'],
            [['animal_name', 'banner', 'feature_image', 'know_as', 'slug'], 'string', 'max' => 255],
            [['short_description'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'animal_name' => 'Animal Name',
            'banner' => 'Banner',
            'feature_image' => 'Feature Image',
            'know_as' => 'Know As',
            'short_description' => 'Short Description',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getImagepath()
    {
        if ($this->feature_image != '') {
            return '/storage/rareanimal/' . $this->id . '/' . $this->feature_image;
        }
    }

    public function getBannerimagepath()
    {
        if ($this->banner != '') {
            return '/storage/rareanimal/' . $this->id . '/' . $this->banner;
        }
    }


    public function getRareparkanimals()
    {
        return $this->hasMany(SafariParkRareAnimal::className(), ['master_rare_animal_id' => 'id'])->andWhere(['safari_park_rare_animal.status' => 1]);
    }
}
