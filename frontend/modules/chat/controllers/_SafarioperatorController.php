<?php

namespace frontend\modules\chat\controllers;

use common\models\operator\SafariOperator;

/**
 * Default controller for the `chat` module
 */
class SafarioperatorController extends \frontend\controllers\FrontendBaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * Start Chating
     */
    public function actionMessage($slug)
    {
        $safari_operator = $this->safarioperator($slug);
        return $this->render('message', [
            'safari_operator' => $safari_operator
        ]);
    }


    /**
     * Safai Operator Model
     */
    protected function safarioperator($slug)
    {
        return SafariOperator::find()->where(['slug' => $slug])->limit(1)->one();
    }
}
