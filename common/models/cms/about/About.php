<?php

namespace common\models\cms\about;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "master_animal".
 *
 * @property string $name
 * @property int $status
 * @property string $description
 */
class About extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'about';
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
            [['name'], 'string', 'max' => 125],
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
