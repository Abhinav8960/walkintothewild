<?php

namespace frontend\modules\account\controllers;

use common\models\BlockedModel;
use Yii;

/**
 * Blocked Members controller for the `account` module
 */
class BlockedMemberController extends \frontend\controllers\FrontendBaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $model = BlockedModel::find()->where(['user_id' => $user->id])->all();
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
