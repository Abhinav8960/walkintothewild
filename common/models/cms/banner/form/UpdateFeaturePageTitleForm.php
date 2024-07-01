<?php

namespace common\models\cms\banner\form;

use Yii;
use yii\base\Model;
use common\models\cms\banner\Banner;

class UpdateFeaturePageTitleForm extends model
{
    public $page_id;
    public $feature_park_title;
    public $feature_page_model;


    public function __construct(Banner $feature_page_model = null)
    {

        $this->feature_page_model = Yii::createObject([
            'class' => Banner::className()
        ]);

        if ($feature_page_model  != '') {
            $this->feature_page_model = $feature_page_model;
            $this->feature_park_title = $this->feature_page_model->feature_park_title;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['feature_park_title'], 'required'],
            [['feature_park_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'feature_park_title' => 'Feature Page Title',
        ];
    }
    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->feature_page_model->feature_park_title = $this->feature_park_title;
    }
}
