<?php

namespace frontend\widgets;

use yii\base\Widget;
use common\models\park\SafariPark;

/**
 * @author Aayush Saini <aayushsaini9999@gmail.com>
 */
class FeatureParkWidget extends Widget
{
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('feature_park_carousel', [
            'featured_parks' => SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'sequence', ''])->limit(5)->orderBy(['sequence' => SORT_ASC])->all()
        ]);
    }
}
