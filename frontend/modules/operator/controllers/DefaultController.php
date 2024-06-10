<?php

namespace frontend\modules\operator\controllers;

use common\interfaces\StatusInterface;
use common\models\cms\article\Article;
use common\models\operator\SafariOperator;
use common\models\park\SafariPark;
use frontend\models\ArticleSearch;
use frontend\models\CommentForm;
use frontend\models\OperatorQuoteForm;
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

        $model = new OperatorQuoteForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->request($operator)) {
            Yii::$app->session->setFlash('success', 'quote Requested Successfully submitted');
            return $this->redirect(['/operator/default/view',  'id' => $id]);
        }

        if (empty($operator)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render(
            'view',
            [
                'operator' => $operator,
                'model' => $model,
            ]
        );
    }
}
