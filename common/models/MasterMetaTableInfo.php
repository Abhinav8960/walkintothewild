<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "master_meta_table_info".
 *
 * @property int $id
 * @property string $name
 * @property int $total_count
 * @property string $last_updated_time
 */
class MasterMetaTableInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_meta_table_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'total_count', 'last_updated_time'], 'required'],
            [['total_count'], 'integer'],
            [['last_updated_time'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'total_count' => 'Total Count',
            'last_updated_time' => 'Last Updated Time',
        ];
    }
}