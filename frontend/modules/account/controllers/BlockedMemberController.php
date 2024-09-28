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
        return $this->render('index', [
            'model' => BlockedModel::find()->where(['user_id' => Yii::$app->user->identity ? Yii::$app->user->identity->id : NULL, 'status' => 1])->all(),
        ]);
    }
}
