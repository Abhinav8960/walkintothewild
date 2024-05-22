<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;

/**
 * @author Aayush Saini <aayushsaini9999@gmail.com>
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


        if (in_array($active_url, array("/safaritour-registration", "/birdingtour-registration", "/coming-soon"))) {
            return $this->render('initialfooter');
        } else {
            return $this->render('footer');
        }
    }
}
