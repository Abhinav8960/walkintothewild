<?php

namespace frontend\modules\profile\controllers;

use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariIntrested;
use common\models\User;
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
    public function actionIndex($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        $organized_by = ShareSafari::find()->where(['host_user_id' => $user->id])->all();
        $joined_by = ShareSafariIntrested::find()->where(['user_id' => $user->id])->all();
        return $this->render(
            'index',
            [
                'user' => $user,
                'organized_by' => $organized_by,
                'joined_by' => $joined_by,
            ]
        );
    }
}
