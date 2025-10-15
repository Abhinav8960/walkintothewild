<?php

namespace support\modules\booking\controllers;

use common\models\bookings\Booking;
use common\models\bookings\BookingSearch;
use yii\web\Controller;
use yii;


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

        $searchModel = new BookingSearch();
        $searchModel->status = Booking::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $tiles_data = Yii::$app->db->createCommand("SELECT 
        (SELECT COUNT(*) FROM `booking` WHERE (`status`=1)) as totalbookings,
        (SELECT count(DISTINCT `email`) FROM `booking` WHERE (`status`=1)) as totalcustomers,
        (SELECT SUM(received_amount) FROM `booking` WHERE (`status`=1)) as totalamount")->queryOne();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalbookings' => $tiles_data['totalbookings'],
            'totalcustomers' => $tiles_data['totalcustomers'],
            'totalamount' => $tiles_data['totalamount'],
        ]);
    }
}
