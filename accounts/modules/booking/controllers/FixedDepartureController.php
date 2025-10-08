<?php

namespace accounts\modules\booking\controllers;

use common\models\bookings\Booking;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariSearch;
use yii\web\Controller;
use yii;

/**
 * Default controller for the `transactioninfo` module
 */
class FixedDepartureController extends Controller
{
    
    public function actionIndex()
    {
        $searchModel = new ShareSafariSearch();
        $searchModel->status = 1;
        $dataProvider = $searchModel->fixeddeparturesearch(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

     public function actionBookedUser($id)
    {
        $share_safari = ShareSafari::findOne($id);
        $booked_users = Booking::find()->where(['share_safari_id' => $id])->andWhere(['status' => 1])->all();

        return $this->render('_booked_user', [
            'booked_users' => $booked_users,
            'share_safari' => $share_safari
        ]);
    }
}
