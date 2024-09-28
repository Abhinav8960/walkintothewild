<?php

namespace common\models\master\bird;

use common\models\meta\MetaBirdType;
use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "master_bird".
 *
 * @property int $id
 * @property string $name
 * @property string|null $bird_type_id
 * @property string $slug
 * @property string|null $know_as
 * @property string|null $short_description
 * @property string|null $long_description
 * @property string|null $image
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class MasterBird extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_bird';
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
            [['name', 'slug', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'required'],
            [['long_description'], 'string'],
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'slug', 'know_as', 'image'], 'string', 'max' => 255],
            [['bird_type_id'], 'string', 'max' => 100],
            [['short_description'], 'string', 'max' => 512],
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
            'bird_type_id' => 'Bird Type ID',
            'slug' => 'Slug',
            'know_as' => 'Know As',
            'short_description' => 'Short Description',
            'long_description' => 'Long Description',
            'image' => 'Image',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
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

    public function getImagepath()
    {
        if ($this->image != '') {
            return '/storage/bird/' . $this->id . '/' . $this->image;
        }
    }

    public function getBirdtype()
    {
        return $this->hasOne(MetaBirdType::className(), ['id' => 'bird_type_id']);
    }
}
