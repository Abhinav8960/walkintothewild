<?php

namespace backend\modules\package\controllers;

use common\interfaces\StatusInterface;
use common\models\master\faq\MasterFaq;
use common\models\package\form\PackageFaqForm;
use common\models\package\form\PackageForm;
use common\models\package\form\PackageTermConditionForm;
use common\models\package\Package;
use common\models\package\PackageFaq;
use common\models\package\PackageFaqSearch;
use common\models\package\PackageFeature;
use common\models\package\PackageIncluded;
use common\models\package\PackageSafariPark;
use common\models\package\PackageTermCondition;
use common\models\package\PackageTermConditionSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ProfileController.
 */
class ProfileController extends Controller
{
    public function actionIndex($package_id)
    {
        $package_model = $this->findModel($package_id);
        $model = new PackageForm($package_model);
        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->package_image = UploadedFile::getInstance($model, 'package_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_model->save(false)) {
                        $model->uploadFile();

                        $package_feature = $model->package_feature;
                        if ($package_feature) {
                            PackageFeature::deleteAll(['package_id' => $model->package_model->id]);
                            foreach ($package_feature as $feature) {
                                $packagefeature = new PackageFeature();
                                $packagefeature->package_id = $model->package_model->id;
                                $packagefeature->feature_id = $feature;
                                $packagefeature->save(false);
                            }
                        }

                        $package_included = $model->package_included;
                        if ($package_included) {
                            PackageIncluded::deleteAll(['package_id' => $model->package_model->id]);
                            foreach ($package_included as $include) {
                                $packageincluded = new PackageIncluded();
                                $packageincluded->package_id = $model->package_model->id;
                                $packageincluded->include_id = $include;
                                $packageincluded->save(false);
                            }
                        }


                        $package_park = $model->package_park;
                        if ($package_park) {
                            PackageSafariPark::deleteAll(['package_id' => $model->package_model->id]);
                            foreach ($package_park as $park) {
                                $packagesafaripark = new PackageSafariPark();
                                $packagesafaripark->package_id = $model->package_model->id;
                                $packagesafaripark->park_id = $park;
                                $packagesafaripark->save(false);
                            }
                        }

                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index', 'package_id' => $package_id]);
                    }
                }
            }
        } else {
            $model->package_model->loadDefaultValues();
        }

        return $this->render('index', [
            'model' => $model,
            'package_model' => $package_model,
        ]);
    }


    public function actionAdditionalInfo($package_id)
    {
        $package_model = $this->findModel($package_id);
        $model = new PackageForm($package_model);
        $model->scenario = 'additional_info';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['additional-info', 'package_id' => $package_id]);
                    }
                }
            }
        } else {
            $model->package_model->loadDefaultValues();
        }

        return $this->render('additional_info', [
            'model' => $model,
            'package_model' => $package_model,
        ]);
    }



    public function actionInclusion($package_id)
    {
        // Find the package model based on $package_id
        $package_model = $this->findModel($package_id);

        // Instantiate PackageForm using the found package model
        $model = new PackageForm($package_model);
        $model->scenario = 'inclusion'; // Set scenario to 'inclusion' for validation purposes

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Validate and save package model
                if ($model->validate()) {
                    // Save the package model first
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        if ($model->package_model->save(false)) {
                            // Save package inclusion options
                            foreach ($model->package_included as $optionId => $selection) {
                                // Check if option exists, and update or create as needed
                                $packageIncluded = PackageIncluded::findOne(['include_id' => $optionId, 'package_id' => $package_id]);
                                if (!$packageIncluded) {
                                    $packageIncluded = new PackageIncluded();
                                    $packageIncluded->include_id = $optionId;
                                    $packageIncluded->package_id = $package_id;
                                }
                                $packageIncluded->selection = $selection;
                                if (!$packageIncluded->save()) {
                                    throw new \Exception('Failed to save package inclusion option ' . $optionId);
                                }
                            }

                            $transaction->commit();
                            Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                            return $this->redirect(['inclusion', 'package_id' => $package_id]);
                        } else {
                            Yii::$app->session->setFlash('error', 'Failed to update package details.');
                        }
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', 'An error occurred while updating data: ' . $e->getMessage());
                    }
                }
            }
        } else {
            // Populate the form with existing data
            $model->package_model->loadDefaultValues(); // Ensure package model has default values

            // Fetch related package inclusion options
            $includedOptions = [];
            foreach ($package_model->packageIncludeds as $includedOption) {
                $includedOptions[$includedOption->include_id] = $includedOption->selection;
            }
            $model->package_included = $includedOptions;
        }

        return $this->render('inclusion', [
            'model' => $model,
            'package_model' => $package_model,
        ]);
    }

    public function actionItinerary($package_id)
    {
        $package_model = $this->findModel($package_id);


        return $this->render('itinerary', [
            'package_model' => $package_model,
        ]);
    }


    public function actionFaq($package_id)
    {
        $package_model = $this->findModel($package_id);
        $searchModel = new PackageFaqSearch();
        $searchModel->package_id = $package_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('faq', [
            'package_model' => $package_model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Create PackageFaqForm.
     * 
     * @return mixed
     */
    public function actionCreateFaq($package_id)
    {
        $package_model = $this->findModel($package_id);
        $model = new PackageFaqForm();
        $model->package_id = $package_id;
        $model->status = StatusInterface::STATUS_ACTIVE;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_faq_model->save(false)) {
                        $faq = new MasterFaq();
                        $faq->question = $model->question;
                        $faq->answer = $model->answer;
                        $faq->position = 0;
                        $faq->status = StatusInterface::STATUS_ACTIVE;
                        $faq->save(false);
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['faq', 'package_id' => $package_id]);
                    }
                }
            }
        } else {
            $model->package_faq_model->loadDefaultValues();
        }


        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create_faq', [
                'model' => $model,
                'package_model' => $package_model,
            ]);
        }
    }


    /**
     * Create PackageFaqForm.
     * 
     * @return mixed
     */
    public function actionSelectFaq($package_id)
    {
        $package_model = $this->findModel($package_id);
        $model = new PackageFaqForm();
        $model->package_id = $package_id;
        $model->status = StatusInterface::STATUS_ACTIVE;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_faq_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['faq', 'package_id' => $package_id]);
                    }
                }
            }
        } else {
            $model->package_faq_model->loadDefaultValues();
        }


        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create_faq', [
                'model' => $model,
                'package_model' => $package_model,
            ]);
        }
    }

    /**
     * Create PackageFaqForm.
     * 
     * @return mixed
     */
    public function actionFaqUpdate($package_id, $id)
    {
        $package_model = $this->findModel($package_id);
        $package_faq_model = $this->findModelfaq($id);
        $model = new PackageFaqForm($package_faq_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_faq_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['faq', 'package_id' => $package_id]);
                    }
                }
            }
        } else {
            $model->package_faq_model->loadDefaultValues();
        }

        return $this->render('create_faq', [
            'model' => $model,
            'package_model' => $package_model,
        ]);
    }

    /**
     * Create PackageTermConditionForm.
     * 
     * @return mixed
     */
    public function actionCreateTermCondition($package_id)
    {
        $package_model = $this->findModel($package_id);
        $model = new PackageTermConditionForm();
        $model->package_id = $package_id;
        $model->status = StatusInterface::STATUS_ACTIVE;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_termcondition_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['term-condition', 'package_id' => $package_id]);
                    }
                }
            }
        } else {
            $model->package_termcondition_model->loadDefaultValues();
        }

        return $this->render('create_term_condition', [
            'model' => $model,
            'package_model' => $package_model,
        ]);
    }

    /**
     * Create PackageTermConditionForm.
     * 
     * @return mixed
     */
    public function actionUpdateTermCondition($package_id, $id)
    {
        $package_model = $this->findModel($package_id);
        $package_termcondition_model = $this->findModeltermcondition($id);
        $model = new PackageTermConditionForm($package_termcondition_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_termcondition_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['term-condition', 'package_id' => $package_id]);
                    }
                }
            }
        } else {
            $model->package_termcondition_model->loadDefaultValues();
        }

        return $this->render('create_term_condition', [
            'model' => $model,
            'package_model' => $package_model,
        ]);
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
        if (($model = Package::findOne(['id' => $id, 'status' => [Package::STATUS_ACTIVE, Package::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelfaq($id)
    {
        if (($model = PackageFaq::findOne(['id' => $id, 'status' => [Package::STATUS_ACTIVE, Package::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModeltermcondition($id)
    {
        if (($model = PackageTermCondition::findOne(['id' => $id, 'status' => [Package::STATUS_ACTIVE, Package::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
