<?php

namespace frontend\modules\manage\controllers;

use Yii;
use frontend\controllers\FrontendBaseController;
use yii\web\UploadedFile;
use common\models\MailLog;
use yii\web\ForbiddenHttpException;
use common\interfaces\StatusInterface;
use common\models\operator\OperatorQuote;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorPark;
use common\models\SafariOperatorRequestSearch;
use common\models\operator\SafariOperatorFollow;
use common\models\operator\SafariOperatorRating;
use common\models\registration\SafariOperatorRequest;
use common\models\registration\SafariOperatorRequestPark;
use common\models\operator\form\SafariOperatorRequestForm;
use common\models\operator\SafariOperatorRatingReportSearch;
use common\models\registration\SafariOperatorRequestActivities;

/**
 * Default controller for the `manage` module
 */
class ParkController extends FrontendBaseController
{
    public $action_ids = ['index'];

    /**
     * Park List of Operator
     */
    public function actionIndex()
    {
        $safari_operator = $this->module->operatormodel();

        $operator_parks = SafariOperatorPark::find()->where(['safari_operator_id' => $safari_operator->id, 'status' => SafariOperatorPark::STATUS_ACTIVE])->all();

        return $this->render('index', [
            'safari_operator' => $safari_operator,
            'operator_parks' => $operator_parks
        ]);
    }
}
