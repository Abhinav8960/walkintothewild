<?php

namespace common\models\master\animal;

use common\models\meta\MetaAnimalType;
use common\traits\CommanRelationship;
use common\models\park\SafariParkAnimal;
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
class MasterAnimal extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;

    const USUAL_ANIMAL_TYPE = 1;
    const RARE_ANIMAL_TYPE = 2;

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
            [['status', 'is_filter', 'is_filter_sequence', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 125],
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
        \common\models\MasterMetaTableInfo::upsert($className, SELF::find()->where(['status' => SELF::STATUS_ACTIVE])->count(), date('Y-m-d H:i:s', SELF::find()->max('updated_at')));
        return  true;
    }

    public function getImagepath()
    {
        if ($this->feature_image != '') {
            return \Yii::$app->params['endpoint'] . '/storage/rareanimal/' . $this->id . '/' . $this->feature_image;
        }
    }

    public function getBannerimagepath()
    {
        if ($this->banner != '') {
            return \Yii::$app->params['endpoint'] . '/storage/rareanimal/' . $this->id . '/' . $this->banner;
        }
    }


    public function getRareparkanimals()
    {
        return $this->hasMany(SafariParkAnimal::className(), ['master_animal_id' => 'id'])->andWhere(['safari_parks_animal.status' => 1]);
    }
}
