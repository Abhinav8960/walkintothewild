<?php

namespace frontend\modules\operator\controllers;

use common\interfaces\StatusInterface;
use common\models\cms\article\Article;
use common\models\operator\SafariOperator;
use common\models\park\SafariPark;
use frontend\models\ArticleSearch;
use frontend\models\CommentForm;
use frontend\models\ReplyForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DefaultController.
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView($id)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'id' => $id])->limit(1)->one();


        if (empty($operator)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render(
            'view',
            [
                'operator' => $operator,
            ]
        );
    }
}
