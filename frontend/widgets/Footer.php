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


        return $this->render('initialfooter');
        // if (in_array($active_url, array("/", "/thankyou", "/safaritour-registration", "/birdingtour-registration", "/coming-soon"))) {
        // } else {
        //     return $this->render('footer');
        // }
    }
}
