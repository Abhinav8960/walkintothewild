<?php

namespace api\modules\profile;

use Yii;
use yii\web\ForbiddenHttpException;

/**
 * profile module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'api\modules\profile\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}
