<?php

namespace frontend\modules\profile\controllers;

use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariIntrested;
use frontend\controllers\FrontendBaseController;


/**
 * ShareSafariController.
 */
class ShareSafariController extends FrontendBaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $organized_by = ShareSafari::find()->where(['host_user_id' => $this->module->user()->id])->all();
        $joined_by = ShareSafariIntrested::find()->where(['user_id' => $this->module->user()->id])->all();
        return $this->render(
            'index',
            [
                'user' => $this->module->user(),
                'organized_by' => $organized_by,
                'joined_by' => $joined_by,
            ]
        );
    }
}
