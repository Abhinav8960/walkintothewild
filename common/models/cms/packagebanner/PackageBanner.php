<?php

namespace common\models\cms\packagebanner;

use Yii;
use common\models\GeneralModel;
use common\traits\CommanRelationship;

/**
 * This is the model class for table "master_package_banner".
 */
class PackageBanner extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_package_banner';
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
            [['package_banner', 'url'], 'string'],
            [['package_banner', 'url'], 'safe'],
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
        if ($this->package_banner != '') {
            return '/storage/package_banner/' . $this->id . '/' . $this->package_banner;
        }
    }
}
