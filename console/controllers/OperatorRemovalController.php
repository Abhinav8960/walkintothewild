<?php

namespace console\controllers;

use common\models\operator\SafariOperator;
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
        $excludedIds = [76, 23, 4, 3, 95, 94];  //id column of operator

        $userIdsToUpdate = SafariOperator::find()
            ->where(['id' => $excludedIds])
            ->all();


        //Delete Operators
        $safariOperators = SafariOperator::find()
            ->where(['not in', 'id', $excludedIds])
            ->all();

        foreach ($safariOperators as $operator) {
            $operator->delete();
        }


        User::updateAll(['is_safari_operator' => 0, 'account_type' => 1]);
        
        foreach ($userIdsToUpdate as $user) {
            $users = User::find()->where(['id' => $user->user_id])->all();
            foreach ($users as $user) {
                $user->is_safari_operator = 1;
                $user->account_type = 3;
                $user->save(false);
            }
        }

        echo "Removed SafariOperators and updated " . count($userIdsToUpdate) . " users.\n";
    }

}
