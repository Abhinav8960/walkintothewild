<?php

namespace frontend\widgets;

use common\models\master\animal\MasterRareAnimal;
use yii\base\Widget;
use common\models\park\SafariPark;

/**
 * @author Aayush Saini <aayushsaini9999@gmail.com>
 */
class RareExoticWidget extends Widget
{
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('rare_exotic', [
            'rare_exotics' => MasterRareAnimal::find()->where(['status' => MasterRareAnimal::STATUS_ACTIVE])->andWhere(['!=', 'is_feature_sequence', ''])->limit(10)->orderBy(['is_feature_sequence' => SORT_ASC])->all(),
        ]);
    }
}
