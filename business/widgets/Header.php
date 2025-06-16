<?php

namespace business\widgets;

use common\models\operator\SafariOperator;
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
        if (!isset(Yii::$app->user->identity)) {
            $this->display = false;
        }

        $safarioperator = SafariOperator::find()->where(['user_id'=>Yii::$app->user->identity->id,'status'=>SafariOperator::STATUS_ACTIVE])->one();

        if ($this->display) {
            return $this->render('header',[
                'safarioperator'=>$safarioperator
            ]);
        }
    }
}
