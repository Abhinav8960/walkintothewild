<?php

namespace console\controllers;

use api\behaviours\Verbcheck;
use common\models\master\faq\MasterFaq;
use common\models\package\form\DayItineraryForm;
use common\models\package\form\PackageFaqForm;
use common\models\package\form\PackageForm;
use common\models\package\Package;
use common\models\package\PackageComment;
use common\models\package\PackageCommentReport;
use common\models\package\PackageDay;
use common\models\package\PackageFaq;
use common\models\package\PackageFaqSearch;
use common\models\package\PackageFeature;
use common\models\package\PackageGallery;
use common\models\package\PackageIncluded;
use common\models\package\PackageSafariPark;
use common\models\package\PackageSearch;
use common\models\package\PackageStates;
use Yii;
use yii\filters\AccessControl;
use yii\console\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * DefaultController.
 */
class PackageApprovalController extends Controller
{


    public function actionPathChange()
    {
        $model = Package::find()->all();
        foreach ($model as $m) {
            if (!empty($m->package_image)) {

                $m->package_image = 'package/' . $m->id . '/' . $m->package_image;
            }
            if (!empty($m->package_banner_image)) {
                $m->package_banner_image = 'package/' . $m->id . '/' . $m->package_banner_image;
            }
            $m->save(false);
        }
        echo 'done';
        die();
    }

    public function actionRemoveFirstcharter()
    {
        $model = Package::find()->all();
        foreach ($model as $m) {
            $m->package_image = substr($m->package_image, 1);
            $m->package_banner_image = substr($m->package_banner_image, 1);
            $m->save(false);
        }
        echo 'done';
        die();
    }


    /**
     * Finds the Package model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Package the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Package::findOne(['id' => $id, 'status' => [Package::APPROVED_AND_LIVE_STATUS, Package::NOT_APPROVED_STATUS]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelDay($id, $day)
    {
        if (($model = PackageDay::findOne(['package_id' => $id, 'day' => $day, 'status' => [PackageDay::STATUS_ACTIVE, PackageDay::STATUS_SUSPEND]])) !== null) {
            return $model;
        }
    }

    public function actionPrepareData()
    {
        $model = Package::find()->all();

        foreach ($model as $m) {

            // $m = $this->findModel($m->id);
            if (empty($m->uuid)) {
                $m->uuid = \Ramsey\Uuid\Uuid::uuid4()->toString() . '-' . date('ymdHi');
                $m->version = 'v1';
                $m->status = Package::EDIATBLE_STATUS;
                $m->save(false);
            }
            // $transaction = Yii::$app->db->beginTransaction();
            try {
                // $m->status = Package::SEND_FOR_APPROVAL_STATUS;
                // $m->save(false);
                $this->updatePackageStatus($m->uuid, $m->version, $m->status);
                $this->copyPackageNow($m->id);
                // Yii::$app->session->setFlash('success', 'Package sent for approval successfully');
            } catch (\Exception $e) {
                Yii::error($e->getMessage());
                // $transaction->rollBack();
                // Yii::$app->session->setFlash('error', 'An error occurred while sending for approval: ' . $e->getMessage());
                // return $this->redirect(Yii::$app->request->referrer);

                // echo "<pre>";
                // print_r($e->getMessage());
                // die();
            }
            // $transaction->commit();
        }

        return 'done';
    }

    // public function actionCopyPackage($id)
    // {

    //     $m = $this->findModel($id);



    //     $transaction = Yii::$app->db->beginTransaction();
    //     try {

    //         $this->copyPackageNow($id, true);
    //         // $this->updatePackageStatus($m->uuid, $m->version, $m->status);
    //         Yii::$app->session->setFlash('success', 'Package copy successfully');
    //     } catch (\Exception $e) {
    //         Yii::error($e->getMessage());
    //         $transaction->rollBack();
    //         Yii::$app->session->setFlash('error', 'An error occurred while sending for approval: ' . $e->getMessage());
    //         echo "<pre>";
    //         print_r($e->getMessage());
    //         die();
    //     }
    //     $transaction->commit();

    //     return $this->redirect(Yii::$app->request->referrer);
    // }


    protected function isPackageEditable()
    {
        $id = Yii::$app->request->get('id');
        $model = Package::findOne(['id' => $id, 'status' => [Package::APPROVED_AND_LIVE_STATUS, Package::NOT_APPROVED_STATUS]]);
        if ($model) {
            return $model->status == Package::EDIATBLE_STATUS;
        } else {
            return false;
        }
    }

    protected function isPackageOwner()
    {

        return true;
    }

    private function copyPackageNow($id, $isNewRecord = false)
    {
        $model = Package::findOne($id);

        if ($model) {
            $newModel = new Package();
            $newModel->attributes = $model->attributes;
            $newModel->version = 'v' . (intval(substr($model->version, 1)) + 1);

            if ($isNewRecord) {
                $newModel->uuid = \Ramsey\Uuid\Uuid::uuid4()->toString() . '-' . date('ymdHi');
                $newModel->version = 'v1';
            }
            $newModel->id = null; // Set the ID to null for the new record
            $newModel->status = Package::EDIATBLE_STATUS;
            $newModel->save(false);
            $this->CopyPackageComment($model->id, $newModel->id);
            $this->CopyPackageCommentReport($model->id, $newModel->id);
            $this->CopyPackageDay($model->id, $newModel->id);
            $this->CopyPackageIncluded($model->id, $newModel->id);
            $this->CopyPackageFeature($model->id, $newModel->id);
            $this->CopyPackageSafariPark($model->id, $newModel->id);
            $this->CopyPackageFaq($model->id, $newModel->id);
            $this->CopyPackageIncludedExcluded($model->id, $newModel->id);
            $this->updatePackageStatus($newModel->uuid, $newModel->version, Package::EDIATBLE_STATUS);

            return $newModel;
        }
        return true;
    }

    private function CopyPackageComment($old_package_id, $new_package_id)
    {
        // package_comment_approval;

        $model = PackageComment::find()->where(['package_id' => $old_package_id])->all();
        if ($model) {
            foreach ($model as $comment) {
                $newModel = new PackageComment();
                $newModel->attributes = $comment->attributes;
                $newModel->id = null; // Set the ID to null for the new record
                $newModel->package_id = $new_package_id;
                $newModel->save(false);
            }
        }

        return true;
    }

    private function CopyPackageCommentReport($old_package_id, $new_package_id)
    {
        // package_comment_report_approval;

        $model = PackageCommentReport::find()->where(['package_id' => $old_package_id])->all();
        if ($model) {
            foreach ($model as $comment) {
                $newModel = new PackageCommentReport();
                $newModel->attributes = $comment->attributes;
                $newModel->id = null; // Set the ID to null for the new record
                $newModel->package_id = $new_package_id;
                $newModel->save(false);
            }
        }

        return true;
    }

    private function CopyPackageDay($old_package_id, $new_package_id)
    {
        // package_day_approval;

        $model = PackageDay::find()->where(['package_id' => $old_package_id])->all();
        if ($model) {
            foreach ($model as $day) {
                $newModel = new PackageDay();
                $newModel->attributes = $day->attributes;
                $newModel->id = null; // Set the ID to null for the new record
                $newModel->package_id = $new_package_id;
                $newModel->save(false);
            }
        }

        return true;
    }

    private function CopyPackageIncluded($old_package_id, $new_package_id)
    {
        // package_included_approval;         
        $model = PackageIncluded::find()->where(['package_id' => $old_package_id])->all();
        if ($model) {
            foreach ($model as $included) {
                $newModel = new PackageIncluded();
                $newModel->attributes = $included->attributes;
                $newModel->id = null; // Set the ID to null for the new record
                $newModel->package_id = $new_package_id;
                $newModel->save(false);
            }
        }

        return true;
    }
    private function CopyPackageFeature($old_package_id, $new_package_id)
    {
        // package_feature_approval;      

        $model = PackageFeature::find()->where(['package_id' => $old_package_id])->all();
        if ($model) {
            foreach ($model as $feature) {
                $newModel = new PackageFeature();
                $newModel->attributes = $feature->attributes;
                $newModel->id = null; // Set the ID to null for the new record
                $newModel->package_id = $new_package_id;
                $newModel->save(false);
            }
        }

        return true;
    }

    private function CopyPackageSafariPark($old_package_id, $new_package_id)
    {
        // package_safari_park_approval; 
        $model = PackageSafariPark::find()->where(['package_id' => $old_package_id])->all();
        if ($model) {
            foreach ($model as $safari) {
                $newModel = new PackageSafariPark();
                $newModel->attributes = $safari->attributes;
                $newModel->id = null; // Set the ID to null for the new record
                $newModel->package_id = $new_package_id;
                $newModel->save(false);
            }
        }

        return true;
    }

    private function CopyPackageFaq($old_package_id, $new_package_id)
    {        // package_faq_approval;
        $model = PackageFaq::find()->where(['package_id' => $old_package_id])->all();
        if ($model) {
            foreach ($model as $faq) {
                $newModel = new PackageFaq();
                $newModel->attributes = $faq->attributes;
                $newModel->id = null; // Set the ID to null for the new record
                $newModel->package_id = $new_package_id;
                $newModel->save(false);
            }
        }

        return true;;
    }

    private function CopyPackageIncludedExcluded($old_package_id, $new_package_id)
    {
        // package_states_approval;   
        $model = PackageIncluded::find()->where(['package_id' => $old_package_id])->all();
        if ($model) {
            foreach ($model as $included) {
                $newModel = new PackageIncluded();
                $newModel->attributes = $included->attributes;
                $newModel->id = null; // Set the ID to null for the new record
                $newModel->package_id = $new_package_id;
                $newModel->save(false);
            }
        }
        return true;
    }

    private function updatePackageStatus($uuid, $version, $status)
    {
        $model = PackageStates::find()->where(['uuid' => $uuid])->one();
        $package = Package::find()->where(['uuid' => $uuid, 'version' => $version])->one();

        if (empty($model)) {
            $model = new PackageStates();
            $model->uuid = $uuid;
            $model->slug = PackageStates::prepareUniqueSlug($package->package_name);
        }
        if ($status == Package::SEND_FOR_APPROVAL_STATUS) {
            if (!empty($model->pending_for_approval_version)) {
                $this->terminatePackage($model->uuid, $model->pending_for_approval_version);
            }
            $model->pending_for_approval_version = $version;
        }
        // if ($status == Package::EDIATBLE_status) {
        //     if (!empty($model->editable_version)) {
        //         $this->terminatePackage($model->uuid, $model->editable_version);
        //     }
        //     $model->editable_version = $version;
        // }
        if ($model->save(false)) {
            return true;
        }
        return false;
    }

    private function terminatePackage($uuid, $version)
    {
        $model = Package::find()->where(['uuid' => $uuid, 'version' => $version])->one();
        if ($model) {
            $model->status = Package::TERMINATED_status;
            $model->save(false);
            return true;
        }
        return false;
    }

    public function upsertEditablePackageStates($uuid, $version)
    {

        $model = PackageStates::find()->where(['uuid' => $uuid])->one();
        if (empty($model)) {
            $model = new PackageStates();
        }
        $model->editable_version = $version;
        $model->uuid = $uuid;
        $model->slug = PackageStates::prepareUniqueSlug($model->package_name);
        $model->save();
        return true;
    }
}
