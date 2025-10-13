<?php

namespace business\modules\booking\controllers;

use common\models\bookings\Booking;
use common\models\bookings\BookingSearch;
use yii\web\Controller;
use yii;
use yii\web\NotFoundHttpException;

use function PHPUnit\Framework\throwException;

/**
 * Default controller for the `transactioninfo` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $safari_operator = $this->module->operatormodel();

        $searchModel = new BookingSearch();
        $searchModel->status = Booking::STATUS_ACTIVE;
        $searchModel->partner_id = $safari_operator->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
