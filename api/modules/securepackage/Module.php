<?php

namespace api\modules\securepackage;

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
    public $controllerNamespace = 'api\modules\securepackage\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}
