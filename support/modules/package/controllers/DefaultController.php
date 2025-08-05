<?php

namespace support\modules\package\controllers;

use common\models\master\faq\MasterFaq;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorFaq;
use common\models\package\form\DayItineraryForm;
use common\models\package\form\PackageFaqForm;
use common\models\package\form\PackageVersionForm;
use common\models\package\PackageVersion;
use common\models\package\PackageComment;
use common\models\package\PackageCommentReport;
use common\models\package\PackageDay;
use common\models\package\PackageFaq;
use common\models\package\PackageFaqSearch;
use common\models\package\PackageFeature;
use common\models\package\PackageGallery;
use common\models\package\PackageIncluded;
use common\models\package\PackageSafariPark;
use common\models\package\PackageVersionSearch;
use common\models\package\Package;
use common\models\package\PackageSearch;
use common\models\partnergallery\PartnerGallery;
use common\models\partnergallery\PartnerGallerySearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * DefaultController.
 */
class DefaultController extends Controller
{

    public $version;
    /**
     * @inheritdoc
     */
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PackageSearch();
        $searchModel->status = Package::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        $model = $this->findModel($id);

        $searchModel = new PackageFaqSearch();
        $searchModel->package_id = $model->package_id;
        $searchModel->version = $model->version;
        $searchModel->status = PackageFaq::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);
        $faqs = $dataProvider->getModels();

        return $this->render('view', [
            'package' => $model,
            'faqs' => $faqs,
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
        if (($model = PackageVersion::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetMasterFaq($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $faq = SafariOperatorFaq::findOne($id);

        if ($faq) {
            return [
                'success' => true,
                'question' => $faq->question,
                'answer' => $faq->answer,
            ];
        }

        return ['success' => false];
    }
}
