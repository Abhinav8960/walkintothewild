<?php

namespace backend\modules\sharesafari\controllers;

use api\models\sharesafari\ShareSafari as ApiShareSafari;
use common\models\master\faq\MasterFaq;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariDay;
use common\models\sharesafari\ShareSafariFaq;
use common\models\sharesafari\ShareSafariFaqSearch;
use common\models\sharesafari\ShareSafariIncluded;
use common\models\sharesafari\ShareSafariParklist;
use common\models\sharesafari\ShareSafariVersion;
use common\models\sharesafari\ShareSafariVersionSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * FixedDepartureController.
 */
class FixedDepartureController extends Controller
{
    public $version;

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

        return $this->render('_fixed_view', [
            'share_safari' => $model,
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
            $fixed_departure->host_user_id = $model->host_user_id;
            $fixed_departure->safari_operator_id = $model->safari_operator_id;
            $fixed_departure->user_id = $model->user_id;
            $fixed_departure->host_type = $model->host_type;
            $fixed_departure->park_id = $model->park_id;
            $fixed_departure->share_safari_agenda_id = $model->share_safari_agenda_id;
            $fixed_departure->no_of_safari = $model->no_of_safari;
            $fixed_departure->start_date = $model->start_date;
            $fixed_departure->end_date = $model->end_date;
            $fixed_departure->cut_off_date = $model->cut_off_date;
            $fixed_departure->image_filepath = $model->image_filepath;
            $fixed_departure->stay_category_id = $model->stay_category_id;
            $fixed_departure->estimate_price_min = $model->estimate_price_min;
            $fixed_departure->estimate_price_max = $model->estimate_price_max;
            $fixed_departure->cost_per_person = $model->cost_per_person;
            $fixed_departure->safari_plan = $model->safari_plan;
            $fixed_departure->total_seat = $model->total_seat;
            $fixed_departure->share_seat = $model->share_seat;
            $fixed_departure->tour_duration = $model->tour_duration;
            $fixed_departure->share_safari_inclusion = $model->share_safari_inclusion;
            $fixed_departure->share_safari_exclusion = $model->share_safari_exclusion;
            $fixed_departure->getting_there = $model->getting_there;
            $fixed_departure->breakfast_included = $model->breakfast_included;
            $fixed_departure->lunch_included = $model->lunch_included;
            $fixed_departure->dinner_included = $model->dinner_included;
            $fixed_departure->meal_not_included = $model->meal_not_included;
            $fixed_departure->pending_for_approval_version = null;
            $fixed_departure->editable_version = null;
            $fixed_departure->live_version = $version;
            $fixed_departure->edit_status = 0;
            $fixed_departure->status = ShareSafari::STATUS_ACTIVE;
            $fixed_departure->partner_gallery_id = $model->partner_gallery_id;
            $fixed_departure->gallery_json = $model->gallery_json;
            $fixed_departure->gallery_version = $model->gallery_version;
            $fixed_departure->save(false);

            $fixed_departure->static_data_json  = $this->prepareJson($fixed_departure->id);
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




    private function copyWithEdit($id)
    {
        $m = $this->findModel($id);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $newModel = $this->copyWithEditFixedDeparture($id);
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'An error occurred while sending for approval: ' . $e->getMessage());
            echo "<pre>";
            print_r($e->getMessage());
            die();
            return $this->redirect(Yii::$app->request->referrer);
        }
        $transaction->commit();
        return $this->redirect(['update', 'id' => $newModel->id]);
    }


    private function copyWithEditFixedDeparture($id, $isNewRecord = false)
    {
        $model = ShareSafariVersion::findOne($id);
        $last_version = ShareSafariVersion::find()->where(['share_safari_id' => $model->share_safari_id])->orderBy(['id' => SORT_DESC])->limit(1)->one();

        if ($model) {
            $newModel = new ShareSafariVersion();
            $newModel->attributes = $model->attributes;
            $this->version = $newModel->version = $last_version->version + 1;

            $newModel->id = null;
            $newModel->status = ShareSafariVersion::EDIATBLE_STATUS;
            $newModel->save(false);

            $this->CopyFixedDepartureDay($model->share_safari_id, $model->version, $newModel->share_safari_id);
            $this->CopyFixedDepartureIncluded($model->share_safari_id, $model->version, $newModel->share_safari_id);;
            $this->CopyFixedDepartureSafariPark($model->share_safari_id, $model->version, $newModel->share_safari_id);
            $this->CopyFixedDepartureFaq($model->share_safari_id, $model->version, $newModel->share_safari_id);
            // $this->updateFixedDepartureStatus($newModel->share_safari_id, $newModel->version, ShareSafariVersion::EDIATBLE_STATUS);
            $model = ShareSafari::find()->where(['id' => $newModel->share_safari_id])->one();
            $model->editable_version = $newModel->version;
            $model->save(false);

            return $newModel;
        }
        return true;
    }


    private function CopyFixedDepartureDay($old_share_safari_id, $old_version, $new_share_safari_id)
    {
        $model = ShareSafariDay::find()->where(['share_safari_id' => $old_share_safari_id, 'version' => $old_version])->all();
        if ($model) {
            foreach ($model as $day) {
                $newModel = new ShareSafariDay();
                $newModel->attributes = $day->attributes;
                $newModel->id = null; // Set the ID to null for the new record
                $newModel->share_safari_id = $new_share_safari_id;
                $newModel->version = $this->version;

                $newModel->save(false);
            }
        }

        return true;
    }

    private function CopyFixedDepartureIncluded($old_share_safari_id, $old_version, $new_share_safari_id)
    {

        $model = ShareSafariIncluded::find()->where(['share_safari_id' => $old_share_safari_id, 'version' => $old_version])->all();
        if ($model) {
            foreach ($model as $included) {
                $newModel = new ShareSafariIncluded();
                $newModel->attributes = $included->attributes;
                $newModel->selection = $included->selection;
                $newModel->id = null; // Set the ID to null for the new record
                $newModel->share_safari_id = $new_share_safari_id;
                $newModel->version = $this->version;

                $newModel->save(false);
            }
        }

        return true;
    }


    private function CopyFixedDepartureSafariPark($old_share_safari_id, $old_version, $new_share_safari_id)
    {

        $model = ShareSafariParklist::find()->where(['share_safari_id' => $old_share_safari_id, 'version' => $old_version])->all();
        if ($model) {
            foreach ($model as $safari) {
                $newModel = new ShareSafariParklist();
                $newModel->attributes = $safari->attributes;
                $newModel->id = null; // Set the ID to null for the new record
                $newModel->share_safari_id = $new_share_safari_id;
                $newModel->version = $this->version;
                $newModel->save(false);
            }
        }

        return true;
    }

    private function CopyFixedDepartureFaq($old_share_safari_id, $old_version, $new_share_safari_id)
    {
        $model = ShareSafariFaq::find()->where(['share_safari_id' => $old_share_safari_id, 'version' => $old_version])->all();
        if ($model) {
            foreach ($model as $faq) {
                $newModel = new ShareSafariFaq();
                $newModel->attributes = $faq->attributes;
                $newModel->id = null;
                $newModel->share_safari_id = $new_share_safari_id;
                $newModel->version = $this->version;

                $newModel->save(false);
            }
        }

        return true;;
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

    public function prepareJson($id)
    {
        $this->layout = \common\interfaces\NewStatusInterface::SHARE_SAFARI_API_LAYOUT_FULL;
        $share_safari = ApiShareSafari::find()->where(['id' => $id])->limit(1)->one();


        $json = [
            'share_safari' => [
                'share_safari_title' => $share_safari->share_safari_title,
                'slug' => $share_safari->slug,
                'no_of_safari' => $share_safari->no_of_safari,
                'start_date' => $share_safari->start_date,
                'end_date' => $share_safari->end_date,
                'cut_off_date' => $share_safari->cut_off_date,
                'types' => $share_safari->types,
                'organized_by_name' => $share_safari->organizedbyname,
                'organized_by_image' => $share_safari->organizedbyimage,
                'organized_slug' => $share_safari->organizedslug,
                'shared_image_path' => $share_safari->sharedimagepath,
                'park_title' => $share_safari->park_title,
                'park_slug' => $share_safari->park_slug,
                'cost_per_person' => (int) ceil($share_safari->cost_per_person),
                'estimate_price_min' => (int) ceil($share_safari->estimate_price_min),
                'estimate_price_max' => (int) ceil($share_safari->estimate_price_max),
                'breakfast_included' => (bool) $share_safari->breakfast_included,
                'lunch_included' => (bool) $share_safari->lunch_included,
                'dinner_included' => (bool) $share_safari->dinner_included,
                'meal_not_included' => (bool) $share_safari->meal_not_included,
                'meals_label' => $share_safari->meals_label,
                'share_safari_inclusion' => $share_safari->share_safari_inclusion,
                'share_safari_exclusion' => $share_safari->share_safari_exclusion,
                'getting_there' => $share_safari->getting_there,
                'safari_plan' => $share_safari->safari_plan,
                'share_safari_agenda' => $share_safari->share_safari_agenda,
                'stay_category_display' => $share_safari->stay_category_display,
                'stay_category_id' => $share_safari->stay_category_id,
                'faqs' => ArrayHelper::toArray($share_safari->faqs),
                'parks' => ArrayHelper::toArray($share_safari->parks),
                'includeds' => ArrayHelper::toArray($share_safari->includeds),
                'share_safari_days' => ArrayHelper::toArray($share_safari->share_safari_days),
                'partner_gallery_id' => $share_safari->partner_gallery_id,
                'gallery_json' => $share_safari->gallery_json,
                'gallery_version' => $share_safari->gallery_version
            ],
        ];

        return json_encode($json);
    }
}
