<?php

namespace business\modules\faqs\controllers;

use common\models\operator\form\SafariOperatorFaqsForm;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorFaq;
use common\models\operator\SafariOperatorFaqSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * DefaultController for the `faqs` module
 */
class DefaultController extends Controller
{
    public function actionIndex()
    {
        $safari_operator = $this->module->operatormodel();
        $searchModel = new SafariOperatorFaqSearch();
        $searchModel->safari_operator_id = $safari_operator->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'safari_operator' => $safari_operator,
        ]);
    }

    public function actionCreate()
    {
        $safari_operator = $this->operatormodel();
        $model = new SafariOperatorFaqsForm();
        $model->status = SafariOperatorFaq::STATUS_ACTIVE;
        $model->safari_operator_id = $safari_operator->id;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->faqs_model->save(false)) {
                        $message = Yii::$app->messageManager->getMessage('common.created', ['{var}' => 'Faq']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->faqs_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'safari_operator' => $safari_operator,
        ]);
    }

    public function actionUpdate($id)
    {
        $safari_operator = $this->operatormodel();
        $faqs_model = $this->findModel($id, $safari_operator->id);
        $model = new SafariOperatorFaqsForm($faqs_model);
        $model->safari_operator_id = $safari_operator->id;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->faqs_model->save(false)) {
                        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Faq']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->faqs_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
            'safari_operator' => $safari_operator,
        ]);
    }


    /**
     * Set Sequence of Privacy Policy
     *
     * @return void
     */
    public function actionSetsequence()
    {
        $searchModel = new SafariOperatorFaqSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, false);
        $dataProvider->pagination = false;
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('setsequence', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('setsequence', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider
            ]);
        }
    }

    /**
     * Save Sequence
     *
     * @return void
     */
    public function actionSavesequence()
    {
        $id_array = explode(',', Yii::$app->request->post('ids'));
        $count = 1;
        foreach ($id_array as $id) {
            SafariOperatorFaq::updateAll([
                'sequence' => $count
            ], ['id' => $id]);
            $count++;
        }
        return true;
    }

    public function actionDelete($id)
    {
        $safari_operator = $this->operatormodel();
        $model = $this->findModel($id, $safari_operator->id);
        $model->status = SafariOperatorFaq::STATUS_DELETE;
        $model->save();
        $message = Yii::$app->messageManager->getMessage('common.deleted', ['{var}' => 'Faq']);
        \Yii::$app->session->setFlash('success', $message);
        return $this->redirect(Yii::$app->request->referrer);
    }

    protected function findModel($id, $safari_operator_id)
    {
        if (($model = SafariOperatorFaq::findOne(['id' => $id, 'safari_operator_id' => $safari_operator_id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function operatormodel()
    {
        if ($operator = SafariOperator::find()->where(['user_id' => Yii::$app->user->identity ? Yii::$app->user->identity->id : null])->limit(1)->one()) {
            return $operator;
        }
        throw new ForbiddenHttpException('You are not Allowed to access this Page');
    }
}
