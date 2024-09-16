<?php

namespace common\models\master\month;

use Yii;

/**
 * This is the model class for table "master_month".
 *
 * @property int $month
 * @property string|null $month_name
 * @property string|null $month_short_name
 */
class MasterMonth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_month';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month'], 'required'],
            [['month'], 'integer'],
            [['month_name'], 'string', 'max' => 10],
            [['month_short_name'], 'string', 'max' => 3],
            [['month'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'month' => 'Month',
            'month_name' => 'Month Name',
            'month_short_name' => 'Month Short Name',
        ];
    }
}
