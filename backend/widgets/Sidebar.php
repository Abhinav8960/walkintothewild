<?php

namespace backend\widgets;

use Yii;
use yii\base\Widget;

/**
 * @author Aayush Saini <aayushsaini9999@gmail.com>
 */
class Sidebar extends Widget
{

    public $display = TRUE;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (!isset(Yii::$app->user->identity)) {
            $this->display = false;
        }

        if ($this->display) {
            return $this->render('sidebar');
        }
    }
}
