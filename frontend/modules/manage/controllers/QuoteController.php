<?php

namespace frontend\modules\manage\controllers;

use frontend\controllers\FrontendBaseController;
// use common\models\operator\OperatorQuote;

/**
 * Default controller for the `manage` module
 */
class QuoteController extends FrontendBaseController
{
    public $action_ids = ['index'];

    /**
     * Park List of Operator
     */
    // public function actionIndex()
    // {
    //     $safari_operator = $this->module->operatormodel();

    //     $query = OperatorQuote::find()->where(['operator_id' => $safari_operator->id]);
    //     $dataProvider = new \yii\data\ActiveDataProvider([
    //         'query' => $query,
    //         'pagination' => [
    //             'pageSize' => 20,
    //         ],
    //         'sort' => [
    //             'defaultOrder' => ['updated_at' => SORT_DESC]
    //         ]
    //     ]);

    //     return $this->render('index', [
    //         'safari_operator' => $safari_operator,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }
}
