<?php

namespace backend\modules\operatorapproval\controllers;

use common\models\operator\SafariOperator;
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
                    $this->makeoperator($model);
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

    public function makeoperator($model)
    {
        $safari_operator_model = new SafariOperator();
        $safari_operator_model->operator_name = $model->name;
        $safari_operator_model->operator_email = $model->email;
        $safari_operator_model->operator_phone_no = $model->phone_no;
        $safari_operator_model->user_id = $model->user_id;
        $safari_operator_model->is_approved = 1;
        $safari_operator_model->safari_operator_request_id = $model->id;
        $safari_operator_model->category_id = 2;
        $safari_operator_model->business_name = $model->business_registration_name;
        $safari_operator_model->register_comapany_name = $model->business_registration_name;
        $safari_operator_model->is_highlighted = 0;
        $safari_operator_model->google_rating = 0;
        $safari_operator_model->google_review_count = 0;
        $safari_operator_model->facebook_url = null;
        $safari_operator_model->instagram_url = null;
        $safari_operator_model->youtube_link = null;
        $safari_operator_model->phone_no = $model->phone_no;
        $safari_operator_model->email = $model->email;
        $safari_operator_model->website = null;
        $safari_operator_model->is_register_company = 0;
        $safari_operator_model->has_a_website = 0;
        $safari_operator_model->has_cancellation_policy = 0;
        $safari_operator_model->wildlife_photographer = 0;
        $safari_operator_model->wildlife_influencer = 0;
        $safari_operator_model->is_offer_premium_budget = 1;
        $safari_operator_model->is_offer_standard_budget = 0;
        $safari_operator_model->is_offer_economical_budget = 0;
        $safari_operator_model->is_wildlife_trekking = 0;
        $safari_operator_model->is_wildlife_non_safari_drive = 0;
        $safari_operator_model->is_bird_watching = 0;
        $safari_operator_model->is_camping = 0;
        $safari_operator_model->starting_price = 2000;
        $safari_operator_model->is_approved = 1;
        if ($safari_operator_model->save(false)) {
            return true;
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
