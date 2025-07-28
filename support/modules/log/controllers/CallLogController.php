<?php

namespace support\modules\log\controllers;

use common\models\CallLogSearch;
use common\models\firebasenotification\FirebaseNotificationLogSearch;
use yii\web\Controller;

/**
 * NotificationLogController.
 */
class CallLogController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CallLogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
