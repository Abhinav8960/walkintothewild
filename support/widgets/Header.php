<?php

namespace support\widgets;

use common\models\User;
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

        $user = User::find()->where(['status'=>User::STATUS_ACTIVE,'id'=>Yii::$app->user->id])->one();

        if ($this->display) {
            return $this->render('header',[
                'user'=>$user
            ]);
        }
    }
}
