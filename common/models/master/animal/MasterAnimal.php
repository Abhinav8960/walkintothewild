<?php

namespace common\models\master\animal;

use common\models\meta\MetaAnimalType;
use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "master_animal".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $know_as
 * @property string|null $image
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class MasterAnimal extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_animal';
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
                'attribute' => 'name', //The attribute from which will be generated
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
            [['name'], 'required'],
            [['status', 'is_filter', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'slug', 'know_as', 'image'], 'string', 'max' => 125],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'know_as' => 'Know As',
            'image' => 'Image',
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
            return '/storage/animal/' . $this->id . '/' . $this->image;
        }
    }

    public function getBannerimagepath()
    {
        if ($this->banner_image != '') {
            return '/storage/animal/' . $this->id . '/' . $this->banner_image;
        }
    }

    public function getAnimaltype()
    {
        return $this->hasOne(MetaAnimalType::className(), ['id' => 'animal_type_id']);
    }
}
