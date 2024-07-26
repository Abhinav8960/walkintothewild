<?php

namespace frontend\modules\profile\controllers;

use common\models\sharesafari\ShareSafari;
use common\models\suggestions\SafariSuggestions;
use common\models\User;
use frontend\controllers\FrontendBaseController;


/**
 * ContributionController.
 */
class ContributionController extends FrontendBaseController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        $suggestions = SafariSuggestions::find()->where(['created_by' => $user->id, 'status' => 1])->all();

        $sharesafrimodel = ShareSafari::find()->where(['host_user_id' => $user->id])->orderby(['id' => SORT_DESC])->limit(2)->all();
        $model_count = ShareSafari::find()->where(['host_user_id' => $user->id])->count();

        return $this->render('index', [
            'user' => $user,
            'suggestions' => $suggestions,
            'sharesafrimodel' => $sharesafrimodel,
            'model_count' => $model_count
        ]);
    }
}
