<?php

namespace business\widgets;

use common\models\partnerregistration\PartnerRegistration;
use Yii;
use yii\base\Widget;

/**
 * @author Smriti Pal <smritipal2201@gmail.com>
 */
class PartnerRejectReason extends Widget
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
        $model = PartnerRegistration :: find()->where(['user_id'=>Yii::$app->user->identity->id])->one();
        if(($model->final_approved != 1 )&& ($model->form1_status == 3 || $model->form2_status == 3 || $model->form3_status == 3 || $model->form4_status == 3 || $model->form5_status == 3)){
        if ($this->display) {
            return $this->render('partnerrejectreason',['model'=>$model]);
        }
    }
    }
}
