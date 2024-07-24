<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;

/**
 * @author Smriti Pal <smritipal2201@gmail.com>
 */
class Header extends Widget
{

    public $display = TRUE;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $active_url = "/" . Yii::$app->requestedRoute;
        if (in_array($active_url, array("/", "/plan-safari", "/safari-packages", "/shared-safari"))) {
            return $this->render('header');
        } else {
            return $this->render('header');
        }
    }
}
