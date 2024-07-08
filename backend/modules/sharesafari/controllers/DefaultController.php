<?php

namespace backend\modules\sharesafari\controllers;

use common\interfaces\StatusInterface;
use common\models\sharesafari\ShareSafariComment;
use frontend\models\ShareSafariSearch;
use Yii;
use yii\web\Controller;

/**
 * DefaultController.
 */
class DefaultController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ShareSafariSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionView($id)
    {
        $comments = ShareSafariComment::find()->where(['share_safari_id' => $id, 'status' => StatusInterface::STATUS_ACTIVE])->all();
        return $this->render('view', [
            'comments' => $comments,
        ]);
    }
}
