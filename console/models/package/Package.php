<?php

namespace console\models\package;

use Yii;

/**
 * This is the model class for table "package".
 *
 * @property int $id
 * @property string $slug
 * @property string|null $live_version
 * @property string|null $pending_for_approval_version
 * @property string|null $editable_version
 * @property string|null $live_version_data
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Package extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'package';
    }


     /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_package');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['live_version', 'pending_for_approval_version', 'editable_version', 'live_version_data', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['slug'], 'required'],
            [['live_version_data'], 'safe'],
            [['created_at', 'updated_at'], 'integer'],
            [['slug'], 'string', 'max' => 255],
            [['live_version', 'pending_for_approval_version', 'editable_version'], 'string', 'max' => 10],
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
            'slug' => 'Slug',
            'live_version' => 'Live Version',
            'pending_for_approval_version' => 'Pending For Approval Version',
            'editable_version' => 'Editable Version',
            'live_version_data' => 'Live Version Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}