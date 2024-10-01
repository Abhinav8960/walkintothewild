<?php

namespace api\modules\sharesafari;

use common\models\operator\SafariOperator;
use Yii;
use yii\web\ForbiddenHttpException;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'api\modules\sharesafari\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}
