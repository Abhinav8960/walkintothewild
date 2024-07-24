<?php

namespace frontend\modules\manage\controllers;

use Yii;
use frontend\controllers\FrontendBaseController;
use common\models\operator\SafariOperatorPark;

/**
 * Default controller for the `manage` module
 */
class ParkController extends FrontendBaseController
{
    public $action_ids = ['index'];

    /**
     * Park List of Operator
     */
    public function actionIndex()
    {
        $safari_operator = $this->module->operatormodel();

        $operator_parks = SafariOperatorPark::find()->where(['safari_operator_id' => $safari_operator->id, 'status' => SafariOperatorPark::STATUS_ACTIVE])->all();

        return $this->render('index', [
            'safari_operator' => $safari_operator,
            'operator_parks' => $operator_parks
        ]);
    }
}
