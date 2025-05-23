<?php

namespace console\controllers;

use console\models\package\PackageComment;
use console\models\package\PackageCommentReport;
use console\models\package\PackageDay;
use console\models\package\PackageFaq;
use console\models\package\PackageFeature;
use console\models\package\PackageIncluded;
use console\models\package\PackageSafariPark;
use console\models\package\PackageVersion;
use console\models\package\Package;
use Yii;
use yii\console\Controller;


/**
 * DefaultController.
 */
class PackageToProductionController extends Controller
{

    public $version = 'v1';

    public function actionPrepareData()
    {
        $model = Package::find()->all();

        foreach ($model as $m) {


            $transaction = Yii::$app->db->beginTransaction();
            try {

                $this->copyPackageNow($m->id, true);
                $this->copyPackageNow($m->id);
            } catch (\Exception $e) {
                Yii::error($e->getMessage());
                $transaction->rollBack();
                // Yii::$app->session->setFlash('error', 'An error occurred while sending for approval: ' . $e->getMessage());
                // return $this->redirect(Yii::$app->request->referrer);

                echo "<pre>";
                print_r([$m->id, $m->package_slug, $e->getMessage()]);
                die();
            }
            $transaction->commit();
        }

        return 'done';
    }


    private function copyPackageNow($id, $isNewRecord = false)
    {
        $model = Package::findOne($id);

        if ($model) {
            if ($isNewRecord) {

                $copyModel = new \common\models\package\Package();
                $copyModel->attributes = $model->attributes;
                $copyModel->package_slug = $model->package_slug;
                $copyModel->status = $model->status;
                $copyModel->id = null; // Set the ID to null for the new record
                $this->version =   $copyModel->live_version = 'v1';
            } else {
                $copyModel = \common\models\package\Package::find()->where(['package_slug' => $model->package_slug])->one();
                $this->version =  $copyModel->editable_version = 'v2';
            }
            $copyModel->save(false);




            $this->CopyPackageVersion($model->id, $copyModel->id);
            $this->CopyPackageComment($model->id, $copyModel->id);
            $this->CopyPackageCommentReport($model->id, $copyModel->id);
            $this->CopyPackageDay($model->id, $copyModel->id);
            $this->CopyPackageIncluded($model->id, $copyModel->id);
            $this->CopyPackageFeature($model->id, $copyModel->id);
            $this->CopyPackageSafariPark($model->id, $copyModel->id);
            $this->CopyPackageFaq($model->id, $copyModel->id);
            // $this->CopyPackageIncludedExcluded($model->id, $copyModel->id);
            // $this->updatePackageStatus($copyModel->uuid, $copyModel->version, Package::EDIATBLE_STATUS);

            return $copyModel;
        }
        return true;
    }

    private function CopyPackageVersion($old_package_id, $new_package_id)
    {
        // package_version_approval;

        $model = Package::find()->where(['id' => $old_package_id])->one();
        if ($model) {
            $copyModel = new \common\models\package\PackageVersion();

            $copyModel->attributes = $model->attributes;
            $copyModel->id = null; // Set the ID to null for the new record
            $copyModel->package_id = $new_package_id;
            $copyModel->version = $this->version;
            $copyModel->status = 3; // editab le status
            if (!empty($m->package_image)) {

                $copyModel->package_image = 'package/' . $model->id . '/' . $model->package_image;
            }
            if (!empty($copyModel->package_banner_image)) {
                $copyModel->package_banner_image = 'package/' . $model->id . '/' . $model->package_banner_image;
            }
            if ($this->version == 'v1') {
                $copyModel->status = 1; // live status
            }
            $copyModel->save(false);
        }

        return true;
    }

    private function CopyPackageComment($old_package_id, $new_package_id)
    {
        // package_comment_approval;

        $model = PackageComment::find()->where(['package_id' => $old_package_id])->all();
        if ($model) {
            foreach ($model as $comment) {
                $copyModel = new \common\models\package\PackageComment();
                $copyModel->attributes = $comment->attributes;
                $copyModel->id = null; // Set the ID to null for the new record
                $copyModel->package_id = $new_package_id;
                $copyModel->version = $this->version;

                $copyModel->save(false);
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
                $copyModel = new \common\models\package\PackageCommentReport();
                $copyModel->attributes = $comment->attributes;
                $copyModel->id = null; // Set the ID to null for the new record
                $copyModel->package_id = $new_package_id;
                $copyModel->version = $this->version;

                $copyModel->save(false);
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
                $copyModel = new \common\models\package\PackageDay();
                $copyModel->attributes = $day->attributes;
                $copyModel->id = null; // Set the ID to null for the new record
                $copyModel->package_id = $new_package_id;
                $copyModel->version = $this->version;

                $copyModel->save(false);
            }
        }

        return true;
    }

    private function CopyPackageIncluded($old_package_id, $new_package_id)
    {
        // package_included_approval;         
        $model = PackageIncluded::find()->where(['package_id' => $old_package_id, 'status' => 1])->all();
        if ($model) {
            foreach ($model as $included) {
                $copyModel = new \common\models\package\PackageIncluded();
                $copyModel->attributes = $included->attributes;
                $copyModel->id = null; // Set the ID to null for the new record
                $copyModel->package_id = $new_package_id;
                $copyModel->version = $this->version;

                $copyModel->save(false);
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
                $copyModel = new \common\models\package\PackageFeature();
                $copyModel->attributes = $feature->attributes;
                $copyModel->id = null; // Set the ID to null for the new record
                $copyModel->package_id = $new_package_id;
                $copyModel->version = $this->version;

                $copyModel->save(false);
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
                $copyModel = new \common\models\package\PackageSafariPark();
                $copyModel->attributes = $safari->attributes;
                $copyModel->id = null; // Set the ID to null for the new record
                $copyModel->package_id = $new_package_id;
                $copyModel->version = $this->version;

                $copyModel->save(false);
            }
        }

        return true;
    }

    private function CopyPackageFaq($old_package_id, $new_package_id)
    {        // package_faq_approval;
        $model = PackageFaq::find()->where(['package_id' => $old_package_id])->all();
        if ($model) {
            foreach ($model as $faq) {
                $copyModel = new \common\models\package\PackageFaq();
                $copyModel->attributes = $faq->attributes;
                $copyModel->id = null; // Set the ID to null for the new record
                $copyModel->package_id = $new_package_id;
                $copyModel->version = $this->version;
                $copyModel->save(false);
            }
        }

        return true;
    }

    // private function CopyPackageIncludedExcluded($old_package_id, $new_package_id)
    // {
    //     // package_states_approval;   
    //     $model = PackageIncluded::find()->where(['package_id' => $old_package_id])->all();
    //     if ($model) {
    //         foreach ($model as $included) {
    //             $copyModel = new \common\models\package\PackageIncluded();
    //             $copyModel->attributes = $included->attributes;
    //             $copyModel->id = null; // Set the ID to null for the new record
    //             $copyModel->package_id = $new_package_id;
    //             $copyModel->version = $this->version;

    //             $copyModel->save(false);
    //         }
    //     }
    //     return true;
    // }

    public function actionMakeLive()
    {
        $model = \common\models\package\Package::find()->where(['status' => 0])->all();
        foreach ($model as $m) {
            $m->status = 1;
            $m->save();
        }
        echo "done";
    }

    public function actionPackageImageSet()
    {
        $package_models = Package::find()->all();
        foreach ($package_models as $package) {
            if ($package->package_image != null) {
                $package->package_image = 'package/' . $package->id . '/' . $package->package_image;
            }

            if ($package->package_banner_image != null) {
                $package->package_banner_image = 'package/' . $package->id . '/' . $package->package_banner_image;
            }

            $package->save(false);
        }
    }

    public function actionPackageCommentDate()
    {
        $model = PackageComment::find()->all();
        if ($model) {
            foreach ($model as $comment) {
            
                $package_model = \common\models\package\PackageComment::find()->where(['id' => $comment->id])->limit(1)->one();
                if ($package_model) {
                    $package_model->created_at = $comment->created_at;
                    $package_model->save(false);
                }
            }
        }

        return true;
    }
}
