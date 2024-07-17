<?php

namespace frontend\modules\profile\controllers;

use common\models\sharesafari\ShareSafari;
use frontend\controllers\FrontendBaseController;


/**
 * ArticleController.
 */
class ArticleController extends FrontendBaseController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = ShareSafari::find()->where(['host_user_id' => $this->module->user()->id])->all();
        return $this->render(
            'index',
            [
                'user' => $this->module->user(),
                'model' => $model
            ]
        );
    }
}
