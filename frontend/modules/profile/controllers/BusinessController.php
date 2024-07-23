<?php

namespace frontend\modules\profile\controllers;

use Yii;
use yii\web\UploadedFile;
use common\interfaces\StatusInterface;
use common\models\MailLog;
use common\models\operator\form\SafariOperatorRequestForm;
use common\models\operator\OperatorQuote;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorFollow;
use common\models\operator\SafariOperatorRating;
use common\models\operator\SafariOperatorRatingReportSearch;
use common\models\registration\SafariOperatorRequest;
use common\models\registration\SafariOperatorRequestActivities;
use common\models\registration\SafariOperatorRequestPark;
use common\models\SafariOperatorRequestSearch;
use frontend\controllers\FrontendBaseController;

/**
 * BusinessController.
 */
class BusinessController extends FrontendBaseController
{

    /**
     * Business Request
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $business_request = SafariOperatorRequest::find()->where(['user_id' => $user->id])->orderby(['id' => SORT_DESC])->one();
        if (!$business_request) {
            Yii::$app->session->setFlash('success', 'No Business Request Found!');
            return $this->redirect(['/profile/default/index', 'user_handle' => $user->user_handle]);
        }

        return $this->render('index', ['user' => $user, 'safari_operator_request' => $business_request]);
    }
}
