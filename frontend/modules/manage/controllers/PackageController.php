<?php

namespace frontend\modules\manage\controllers;

use common\models\package\Package;
use frontend\controllers\FrontendBaseController;

/**
 * Default controller for the `manage` module
 */
class PackageController extends FrontendBaseController
{
    public $action_ids = ['index'];

    /**
     * Park List of Operator
     */
    public function actionIndex()
    {
        $safari_operator = $this->module->operatormodel();

        $query = Package::find()->where([
            'owned_by_id' => $safari_operator->id,
            'status' => 1
        ]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('index', [
            'safari_operator' => $safari_operator,
            'dataProvider' => $dataProvider
        ]);
    }
}
