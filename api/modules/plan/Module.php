<?php

namespace api\modules\plan;

use Yii;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    // public $controllerNamespace = 'backend\modules\admin\controllers';
    public $controllerNamespace = 'api\modules\plan\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}
