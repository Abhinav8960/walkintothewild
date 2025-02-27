<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;

/**
 * @author Smriti Pal <smritipal2201@gmail.com>
 */
class AccountPopup extends Widget
{

    public $display = false;

    public function __construct()
    {
        if (!Yii::$app->user->isGuest && \Yii::$app->user->identity->account_type == 1 && Yii::$app->requestedRoute != 'account/default/registration-operator') {
            $this->display = true;
        }
    }
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if ($this->display) {

            return $this->render('account_popup');
        }
    }
}
