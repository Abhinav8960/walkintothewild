<?php

namespace backend\modules\operatorapproval\controllers;

use common\models\operatorregistration\OperatorRegistration;
use common\models\operatorregistration\OperatorRegistrationSearch;
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
    public function actionIndex()
    {
        $searchModel = new OperatorRegistrationSearch();
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {

        $model = $this->findModel($id);

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function actionStepApproved($id, $step)
    {
        $model = $this->findModel($id);
        if ($step == 1) {
            $model->is_step_1_approved = 1;
            $model->updated_time_step_1 = date('Y-m-d H:i:s');
        } else if ($step == 2) {
            $model->is_step_2_approved = 1;
            $model->updated_time_step_2 = date('Y-m-d H:i:s');
        } else if ($step == 3) {
            $model->is_step_3_approved = 1;
            $model->updated_time_step_3 = date('Y-m-d H:i:s');
        } else if ($step == 4) {
            $model->is_step_4_approved = 1;
            $model->updated_time_step_4 = date('Y-m-d H:i:s');
        }

        if ($model->save(false)) {
            \Yii::$app->session->setFlash('success', 'Approved Successfully');
            if ($model->is_step_1_approved == 1 && $model->is_step_2_approved == 1 && $model->is_step_3_approved == 1 && $model->is_step_4_approved == 1) {
                $model->final_approved = 1;
                $model->updated_time_final_approved = date('Y-m-d H:i:s');
                if ($model->save(false)) {
                    \Yii::$app->session->setFlash('success', 'Final Approved Successfully');
                    return $this->redirect(['update', 'id' => $model->id]);
                }
            }
            return $this->redirect(['update', 'id' => $model->id]);
        }
    }

    public function actionStepReject($id, $step)
    {
        $model = $this->findModel($id);
        if ($step == 1) {
            $model->is_step_1_approved = 2;
            $model->updated_time_step_1 = date('Y-m-d H:i:s');
        } else if ($step == 2) {
            $model->is_step_2_approved = 2;
            $model->updated_time_step_2 = date('Y-m-d H:i:s');
        } else if ($step == 3) {
            $model->is_step_3_approved = 2;
            $model->updated_time_step_3 = date('Y-m-d H:i:s');
        } else if ($step == 4) {
            $model->is_step_4_approved = 2;
            $model->updated_time_step_4 = date('Y-m-d H:i:s');
        }

        if ($model->save(false)) {
            if ($model->is_step_1_approved == 2 || $model->is_step_2_approved == 2 || $model->is_step_3_approved == 2 || $model->is_step_4_approved == 2) {
                $model->final_approved = 2;
                $model->updated_time_final_approved = date('Y-m-d H:i:s');
                if ($model->save(false)) {
                    \Yii::$app->session->setFlash('success', 'Final Approved Successfully');
                    return $this->redirect(['update', 'id' => $model->id]);
                }
            }
            \Yii::$app->session->setFlash('success', 'Business Detail Approved Successfully');
            return $this->redirect(['update', 'id' => $model->id]);
        }
    }

    protected function findModel($id)
    {
        if (($model = OperatorRegistration::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
