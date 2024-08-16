<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;

/**
 * @author Smriti Pal <smritipal2201@gmail.com>
 */
class Footer extends Widget
{

    public $display = TRUE;

    /**
     * {@inheritdoc}
     */
    public function run()
    {

        $active_url = "/" . Yii::$app->requestedRoute;

        // return $this->render('footer');

        if (str_starts_with($active_url, '/profile') || str_starts_with($active_url, '/manage') || str_starts_with($active_url, '/account')){
            return $this->render('profilefooter');
        } else {
            return $this->render('footer');
        }
    }
}
