<?php

namespace business\modules\mybusinessprofile\controllers;

use common\models\operator\SafariOperator;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DefaultController for the `mybusinessprofile` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $safari_operator_model = $this->findModel();

        return $this->render('index', [
            'safari_operator_model' => $safari_operator_model,
        ]);
    }

    protected function findModel()
    {
        if (($model = SafariOperator::find()->where(['user_id' => Yii::$app->user->identity ? Yii::$app->user->identity->id : null,'status'=>SafariOperator::STATUS_ACTIVE])->limit(1)->one()) !== null) {
            return $model;
        }
        
        $message = Yii::$app->messageManager->getMessage('common.page_not_exist');
        throw new NotFoundHttpException($message);
    }

}
