<?php

namespace common\models\cms\privacypolicy;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "privacy_policy".
 *
 * @property string $name
 * @property int $status
 * @property string $description
 */
class Privacypolicy extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'privacy_policy';
    }



    /**
     * {@inheritdoc}
     */

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 512],
            [['description'], 'safe'],
            
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
            'description' => 'Description'
        ];
    }

}
