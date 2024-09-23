<?php

namespace api\modules\park;

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
    public $controllerNamespace = 'api\modules\park\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}
