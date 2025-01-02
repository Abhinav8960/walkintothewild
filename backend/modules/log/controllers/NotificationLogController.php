<?php

namespace backend\modules\log\controllers;

use common\models\firebasenotification\FirebaseNotificationLogSearch;
use yii\web\Controller;

/**
 * NotificationLogController.
 */
class NotificationLogController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FirebaseNotificationLogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
