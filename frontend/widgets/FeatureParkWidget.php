<?php

namespace frontend\widgets;

use yii\base\Widget;
use common\models\park\SafariPark;

/**
 * @author Aayush Saini <aayushsaini9999@gmail.com>
 */
class FeatureParkWidget extends Widget
{
    public $default_title = 'BEST SAFARIS DURING <br>MONSOON SEASON';
    public $section_title = 'BEST SAFARIS DURING <br>MONSOON SEASON';

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('feature_park_carousel', [
            'featured_parks' => SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'sequence', ''])->orderBy(['sequence' => SORT_ASC])->all(),
            'section_title' => $this->section_title <> '' ? $this->section_title : $this->default_title,
        ]);
    }
}
