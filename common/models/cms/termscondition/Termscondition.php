<?php

namespace common\models\cms\termscondition;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "terms_condition".
 *
 * @property string $type
 * @property int $status
 * @property string $description
 */
class Termscondition extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'terms_condition';
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
            [['type'], 'required'],
            [['status'], 'integer'],
            [['type'], 'string', 'max' => 251],
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
            'type' => 'Type',
            'description' => 'Module Description'
        ];
    }

}
