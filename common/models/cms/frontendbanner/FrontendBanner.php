<?php

namespace common\models\cms\frontendbanner;

use Yii;
use common\models\GeneralModel;
use common\traits\CommanRelationship;

/**
 * This is the model class for table "master_package_banner".
 */
class FrontendBanner extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;
    const TYPE_PACKAGE = 1;
    const TYPE_SHARED_SAFARI = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_frontend_banner';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['frontend_banner', 'url'], 'string'],
            [['frontend_banner', 'url'], 'safe'],
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
            'status' => 'Status',
            'url' => 'Link',
            'statuslabel' => 'Status',
        ];
    }


    public function getImagepath()
    {
        if ($this->frontend_banner != '') {
            return \Yii::$app->params['endpoint'] . '/frontend_banner/' . $this->id . '/' . $this->frontend_banner;
        }
    }

    public function getName()
    {
        if ($this->type == 1) {
            return 'Package Banner';
        } else if ($this->type == 2) {
            return 'Shared Safari Banner';
        }
    }
}
