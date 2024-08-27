<?php

namespace common\models\cms\sharedsafaribanner;

use Yii;
use common\models\GeneralModel;
use common\traits\CommanRelationship;

/**
 * This is the model class for table "master_shared_safari_banner".
 */
class SharedSafariBanner extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_shared_safari_banner';
    }

    // public function behaviors()
    // {
    //     return [
    //         \yii\behaviors\TimestampBehavior::className(),
    //         \yii\behaviors\BlameableBehavior::className(),
    //     ];
    // }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shared_safari_banner', 'url'], 'string'],
            [['shared_safari_banner', 'url'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'url' => 'Link',
            'statuslabel' => 'Status',
        ];
    }


    public function getImagepath()
    {
        if ($this->shared_safari_banner != '') {
            return '/storage/shared_safari_banner/' . $this->id . '/' . $this->shared_safari_banner;
        }
    }
}
