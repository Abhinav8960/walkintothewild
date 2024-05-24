<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;

/**
 * @author Aayush Saini <aayushsaini9999@gmail.com>
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
        if (in_array($active_url, array("/safaritour-registration", "/birdingtour-registration","/thankyou"))) {
            return $this->render('initialheader');
        } else if (in_array($active_url, array("/", "/coming-soon"))) {
        } else {
            return $this->render('header');
        }
    }
}
