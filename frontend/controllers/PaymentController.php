<?php

namespace frontend\controllers;

use Yii;
use common\models\leads\LeadPartnerQuoteInstallments;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class PaymentController extends FrontendBaseController
{

    public function actionInitiation($payment_hash)
    {
        $model = LeadPartnerQuoteInstallments::find()->where(['payment_hash' => $payment_hash])->one();

        if (empty($model)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('choose_gateway', [
            'model' => $model,
        ]);
    }
}
