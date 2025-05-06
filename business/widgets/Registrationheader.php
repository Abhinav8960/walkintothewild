<?php

namespace business\widgets;

use Yii;
use yii\base\Widget;

/**
 * @author Smriti Pal <smritipal2201@gmail.com>
 */
class Registrationheader extends Widget
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
            return $this->render('registrationheader');
        }
    }
}
