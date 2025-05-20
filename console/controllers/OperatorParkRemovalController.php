<?php

namespace console\controllers;

use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorPark;
use common\models\sharesafari\ShareSafari;
use common\models\User;
use Yii;
use yii\console\Controller;



/**
 * OperatorRemovalController
 */
class OperatorParkRemovalController extends Controller
{
    public function actionRemove()
    {
        $safari_operator_ids = [3, 4, 23, 76, 94, 95, 96, 97, 98, 99, 100];

        $excludedIds = SafariOperatorPark::find()
            ->where(['safari_operator_id' => $safari_operator_ids, 'status' => SafariOperatorPark::STATUS_ACTIVE])
            ->all();


        $safari_operator_parks = SafariOperatorPark::find()
            ->where(['not in', 'id', $excludedIds])
            ->all();

        foreach ($safari_operator_parks as $safari_operator_park) {
            $safari_operator_park->status = 0;
            $safari_operator_park->save(false);
        }
    }
}
