<?php

namespace backend\modules\sharesafari\controllers;

use common\models\master\faq\MasterFaq;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariFaqSearch;
use common\models\sharesafari\ShareSafariVersion;
use common\models\sharesafari\ShareSafariVersionSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * FixedDepartureController.
 */
class FixedDepartureController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ShareSafariVersionSearch();
        $searchModel->status = ShareSafariVersion::SEND_FOR_APPROVAL_STATUS;
        $dataProvider = $searchModel->partnersearch(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        $searchModel = new ShareSafariFaqSearch();
        $searchModel->share_safari_id = $model->share_safari_id;
        $searchModel->version = $model->version;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);
        $faqs = $dataProvider->getModels();

        return $this->render('view', [
            'package' => $model,
            'faqs' => $faqs,
        ]);
    }

   
    protected function findModel($id)
    {
        if (($model = ShareSafariVersion::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionApproved($share_safari_id, $version)
    {
        $fixed_departure = ShareSafari::find()->where(['id' => $share_safari_id, 'pending_for_approval_version' => $version])->one();
        if (empty($fixed_departure)) {
            Yii::$app->session->setFlash('error', 'Fixed Departure not found.');
            return $this->redirect(['index']);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!empty($fixed_departure->live_version)) {
                $this->terminateFixedDeparture($share_safari_id, $fixed_departure->live_version);
            }
            $model = ShareSafariVersion::find()->where(['share_safari_id' => $share_safari_id, 'version' => $version])->one();

            $fixed_departure->share_safari_title = $model->share_safari_title;
            $fixed_departure->type = $model->type;
            $fixed_departure->share_safari_request_id = $model->share_safari_request_id;
            $fixed_departure->host_user_id = $model->host_user_id;
            $fixed_departure->host_type = $model->host_type;
            $fixed_departure->park_id = $model->park_id;
            $fixed_departure->share_safari_agenda_id = $model->share_safari_agenda_id;
            $fixed_departure->no_of_safari = $model->no_of_safari;
            $fixed_departure->start_date = $model->start_date;
            $fixed_departure->end_date = $model->end_date;
            $fixed_departure->cut_off_date = $model->cut_off_date;
            $fixed_departure->image = $model->image;
            $fixed_departure->filepath = $model->filepath;
            $fixed_departure->stay_category_id = $model->stay_category_id;
            $fixed_departure->estimate_price_min = $model->estimate_price_min;
            $fixed_departure->estimate_price_max = $model->estimate_price_max;
            $fixed_departure->cost_per_person = $model->cost_per_person;
            $fixed_departure->safari_plan = $model->safari_plan;
            $fixed_departure->website_url = $model->website_url;
            $fixed_departure->total_seat = $model->total_seat;
            $fixed_departure->share_seat = $model->share_seat;
            $fixed_departure->tour_duration = $model->tour_duration;
            $fixed_departure->share_safari_inclusion = $model->share_safari_inclusion;
            $fixed_departure->share_safari_exclusion = $model->share_safari_exclusion;
            $fixed_departure->share_safari_terms_condtition = $model->share_safari_terms_condtition;
            $fixed_departure->privacy_policy = $model->privacy_policy;
            $fixed_departure->change_policy = $model->change_policy;
            $fixed_departure->what_you_must_carry = $model->what_you_must_carry;
            $fixed_departure->date_change_policy = $model->date_change_policy;
            $fixed_departure->refund_policy = $model->refund_policy;
            $fixed_departure->getting_there = $model->getting_there;
            $fixed_departure->breakfast_included = $model->breakfast_included;
            $fixed_departure->lunch_included = $model->lunch_included;
            $fixed_departure->dinner_included = $model->dinner_included;
            $fixed_departure->meal_not_included = $model->meal_not_included;
            $fixed_departure->pending_for_approval_version = null;
            $fixed_departure->live_version = $version;
            $fixed_departure->status = ShareSafari::STATUS_ACTIVE;
            $fixed_departure->save(false);

            $model->status = ShareSafariVersion::APPROVED_AND_LIVE_STATUS;
            $model->final_approved_at = time();

            $model->save(false);
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'An error occurred while sending for approval: ' . $e->getMessage());
            echo "<pre>";
            print_r($e->getMessage());
            die();
            Yii::$app->session->setFlash('error', 'Failed to approve fixed departure.');
            return $this->redirect(['index']);
        }
        $transaction->commit();


        Yii::$app->session->setFlash('success', 'Fixed departure approved and Live successfully.');
        return $this->redirect(Yii::$app->request->referrer);
    }


    private function terminateFixedDeparture($share_safari_id, $version)
    {
        $model = ShareSafariVersion::find()->where(['share_safari_id' => $share_safari_id, 'version' => $version])->one();
        if ($model) {
            $model->status = ShareSafariVersion::TERMINATED_STATUS;
            $model->save(false);
            return true;
        }
        return false;
    }

    //  public function actionRejectview($share_safari_id, $version)
    // {
    //     $model = Package::find()->where(['id' => $share_safari_id, 'version' => $version])->one();

    //     if (Yii::$app->request->isAjax) {
    //         return $this->renderAjax('_rejection_form', [
    //             'share_safari_id' => $share_safari_id,
    //             'version' => $version,
    //             'model' => $model
    //         ]);
    //     }
    // }

    // public function actionReject($share_safari_id, $version)
    // {
    //     $package = Package::find()->where(['id' => $share_safari_id, 'pending_for_approval_version' => $version])->one();
    //     if (empty($package)) {
    //         Yii::$app->session->setFlash('error', 'Package not found.');
    //         return $this->redirect(['index']);
    //     }
    //     $model = PackageVersion::find()->where(['share_safari_id' => $share_safari_id, 'version' => $version])->one();
    //     $model->scenario = 'reject';

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post())) {
    //             // $transaction = Yii::$app->db->beginTransaction();
    //             // try {
    //             $package->pending_for_approval_version = null;
    //             $package->save(false);

    //             $model->status = PackageVersion::NOT_APPROVED_STATUS;
    //             $model->cancellation_reason = \Yii::$app->request->post('PackageVersion')['cancellation_reason'] ?? NULL;
    //             $model->save(false);
    //             // } catch (\Exception $e) {
    //             //     Yii::error($e->getMessage());
    //             //     $transaction->rollBack();
    //             //     Yii::$app->session->setFlash('error', 'Failed to reject package.');
    //             //     return $this->redirect(Yii::$app->request->referrer);
    //             // }
    //             // $transaction->commit();
    //             Yii::$app->session->setFlash('success', 'Package rejected successfully.');
    //             return $this->redirect(['index']);
    //         }
    //     }

    //     if (Yii::$app->request->isAjax) {
    //         return $this->renderAjax('_rejection_form', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

   
}
