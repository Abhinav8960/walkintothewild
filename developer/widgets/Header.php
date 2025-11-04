<?php

namespace developer\widgets;

use common\models\User;
use Yii;
use yii\base\Widget;

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

        $user = User::find()->where(['id'=>Yii::$app->user->identity->id,'status'=>User::STATUS_ACTIVE])->andWhere(['is_developer'=>1])->one();

        if ($this->display) {
            return $this->render('header',[
                'user'=>$user
            ]);
        }
    }
}
