<?php

namespace common\models\package;

use Google\Service\CloudDeploy\Stage;
use Yii;

/**
 * This is the model class for table "package_states_approval".
 *
 * @property int $id
 * @property string $uuid
 * @property string $slug
 * @property string $live_version
 * @property string $pending_for_approval_version
 * @property string $editable_version
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class PackageStates extends \yii\db\ActiveRecord
{


    public function behaviors()
    {
        return [
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
    public static function tableName()
    {
        return 'package_states';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['uuid', 'slug', 'live_version', 'pending_for_approval_version', 'editable_version'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['uuid', 'slug'], 'string', 'max' => 255],
            [['live_version', 'pending_for_approval_version', 'editable_version'], 'string', 'max' => 10],
            [['uuid', 'slug'], 'unique', 'targetAttribute' => ['uuid', 'slug']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uuid' => 'Uuid',
            'slug' => 'Slug',
            'live_version' => 'Live Version',
            'pending_for_approval_version' => 'Pending For Approval Version',
            'editable_version' => 'Editable Version',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function prepareUniqueSlug($str)
    {
        $slug = \yii\helpers\Inflector::slug($str, '-');
        $count = 0;
        $originalSlug = $slug;

        while (self::find()->where(['slug' => $slug])->exists()) {
            $count++;
            $slug = $originalSlug . '-' . $count;
        }

        return $slug;
    }

}