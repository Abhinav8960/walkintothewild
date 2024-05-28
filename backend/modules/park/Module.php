<?php

namespace backend\modules\park;

use Yii;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\park\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (!isset(Yii::$app->user->identity)) {
            return Yii::$app->getResponse()->redirect('/site/login')->send();
            exit;
        }
        parent::init();

        $this->modules = [
            'safari' => [
                'class' => 'backend\modules\park\modules\safari\Module',
            ],
            'birding' => [
                'class' => 'backend\modules\park\modules\birding\Module',
            ],

        ];
    }
}
