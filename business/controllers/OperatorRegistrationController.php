<?php

namespace business\controllers;

use common\models\operator\SafariOperator;
use common\models\operatorregistration\form\OperatorRegistrationForm;
use common\models\operatorregistration\OperatorRegistration;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

use Yii;



/**
 * OperatorFormController implements the CRUD actions for OperatorForm model.
 */
class OperatorRegistrationController extends Controller
{
    public function actionIndex()
    {
        if (!SafariOperator::find()->where(['user_id' => \Yii::$app->user->id])->limit(1)->exists()) {
            return $this->redirect(['/operator-registration/create']);
        }
    }

    public function actionCreate()
    {
        $this->layout = 'registration';

        if (Yii::$app->user->identity) {
            $operator_model = OperatorRegistration::findOne(['user_id' => Yii::$app->user->identity->id]);
            if (!$operator_model) {
                $model = new OperatorRegistrationForm();
            } else {
                $model = new OperatorRegistrationForm($operator_model);
            }
        }

        $model->user_id = Yii::$app->user->identity->id;
        $model->setScenario(OperatorRegistrationForm::SCENARIO_STEP1);

        $model->is_step_1_submit = 1;
        if ($operator_model && $operator_model->is_step_1_approved != 1) {
            $model->is_step_1_approved = 0;
        }

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    $model->operator_model->current_step = 2;
                    if ($model->operator_model->save()) {
                        return $this->redirect(['step-2']);
                    }
                }
            }
        } else {
            $model->operator_model->loadDefaultValues();
        }

        return $this->render('_step1', [
            'model' => $model,
            'operator_model' => $operator_model,
        ]);
    }

    public function actionStep2()
    {
        $this->layout = 'registration';
        $operator_model = $this->findModel();

        if ($operator_model->current_step < 2) {
            return $this->redirect(['create']);
        }

        $model = new OperatorRegistrationForm($operator_model);
        $model->setScenario(OperatorRegistrationForm::SCENARIO_STEP2);
        $model->current_step = 3;

        $model->is_step_2_submit = 1;
        if ($operator_model->is_step_2_approved != 1) {
            $model->is_step_2_approved = 0;
        }


        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->operator_model->save(false)) {
                        return $this->redirect(['step-3']);
                    }
                }
            }
        } else {
            $model->operator_model->loadDefaultValues();
        }

        return $this->render('_step2', [
            'model' => $model,
            'operator_model' => $operator_model,
        ]);
    }
    public function actionStep3()
    {
        $this->layout = 'registration';
        $operator_model = $this->findModel();

        if ($operator_model->current_step < 3) {
            return $this->redirect(['step-2']);
        }

        $model = new OperatorRegistrationForm($operator_model);
        $model->setScenario(OperatorRegistrationForm::SCENARIO_STEP3);
        $model->current_step = 4;

        $model->is_step_3_submit = 1;
        if ($operator_model->is_step_3_approved != 1) {
            $model->is_step_3_approved = 0;
        }


        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->operator_model->save(false)) {
                        return $this->redirect(['step-4']);
                    }
                }
            }
        } else {
            $model->operator_model->loadDefaultValues();
        }

        return $this->render('_step3', [
            'model' => $model,
            'operator_model' => $operator_model,
        ]);
    }

    public function actionStep4()
    {
        $this->layout = 'registration';

        $operator_model = $this->findModel();

        if ($operator_model->current_step < 4) {
            return $this->redirect(['step-3']);
        }
        $model = new OperatorRegistrationForm($operator_model);
        $model->setScenario(OperatorRegistrationForm::SCENARIO_STEP4);
        $model->current_step = 5;

        $model->is_step_4_submit = 1;
        if ($operator_model->is_step_4_approved != 1) {
            $model->is_step_4_approved = 0;
        }

        $model->final = 1;
        $model->updated_time_final = date('Y-m-d H:i:s');

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->operator_model->save(false)) {
                        return $this->redirect(['view',]);
                    }
                }
            }
        } else {
            $model->operator_model->loadDefaultValues();
        }

        return $this->render('_step4', [
            'model' => $model,
            'operator_model' => $operator_model,
        ]);
    }

    public function actionView()
    {
        $this->layout = 'registration';
        $operator_model = $this->findModel();
        return $this->render('_step5', [
            'operator_model' => $operator_model,
        ]);
    }

    /**
     * Finds the OperatorRegistration model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return OperatorRegistration the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel()
    {
        if (($model = OperatorRegistration::find()->where(['user_id' => Yii::$app->user->identity->id])->orderBy(['id' => SORT_DESC])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
