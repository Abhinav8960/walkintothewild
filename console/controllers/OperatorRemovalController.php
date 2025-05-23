<?php

namespace console\controllers;

use common\models\operator\SafariOperator;
use common\models\sharesafari\ShareSafari;
use common\models\User;
use Yii;
use yii\console\Controller;



/**
 * OperatorRemovalController
 */
class OperatorRemovalController extends Controller
{
    public function actionRemove()
    {
        // $excludedIds = [76, 23, 4, 3];  //id column of operator
        $excludedIds = [76, 4, 3];  //id column of operator

        $userIdsToUpdate = SafariOperator::find()
            ->where(['id' => $excludedIds])
            ->all();

        foreach ($userIdsToUpdate as $active_operator) {
            $active_operator->status = 1;
            $active_operator->save(false);
        }

        //Delete Operators
        $safariOperators = SafariOperator::find()
            ->where(['not in', 'id', $excludedIds])
            ->all();

        foreach ($safariOperators as $operator) {
            $operator->status = 0;
            $operator->save(false);
            $user = User::find()->where(['id' => $operator->user_id])->one();
            if ($user) {
                $user->email = time() . '_' . $user->email;
                $user->google_source_id = time() . '_' . $user->google_source_id;
                $user->is_safari_operator = 1;
                $user->account_type = 3;
                $user->status = 9;
                $user->save(false);
            }
        }


        // User::updateAll(['is_safari_operator' => 0, 'account_type' => 1]);

        foreach ($userIdsToUpdate as $user) {
            $users = User::find()->where(['id' => $user->user_id])->all();
            foreach ($users as $user) {
                $user->is_safari_operator = 1;
                $user->account_type = 3;
                $user->status = 10;
                $user->save(false);
            }
        }

        echo "Removed SafariOperators and updated " . count($userIdsToUpdate) . " users.\n";
    }


    public function actionFixedAssign()
    {
        $ids = [76, 23, 4, 3, 95, 94];
        $fixed_departures = ShareSafari::find()->where(['type' => 2])->all();

        foreach ($fixed_departures as $fd) {
            $randomKey = array_rand($ids);
            $fd->host_user_id = $ids[$randomKey];
            $fd->save(false);
        }
        echo "Successfully Updated";
    }
}
