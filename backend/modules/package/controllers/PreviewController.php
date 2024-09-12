<?php

namespace backend\modules\package\controllers;

use common\interfaces\StatusInterface;
use common\models\package\form\PackageForm;
use common\models\package\Package;
use common\models\package\PackageCommentSearch;
use common\models\package\PackageFaqSearch;
use common\models\package\PackageFeature;
use common\models\package\PackageIncluded;
use common\models\package\PackageSafariPark;
use common\models\package\PackageSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * PreviewController.
 */
class PreviewController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($id)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'id' => $id])->limit(1)->one();
        if (empty($package)) {
            return $this->redirect(['/package']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $searchModel = new PackageFaqSearch();
        $searchModel->package_id = $package->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);
        $faqs = $dataProvider->getModels();

        $commentsearchModel = new PackageCommentSearch();
        $commentsearchModel->package_id = $package->id;
        $commentProvider = $commentsearchModel->listingsearch($this->request->queryParams);
        $commentProvider->query->andWhere(['parent_id' => null]);

        return $this->render(
            'view',
            [
                'package' => $package,
                'faqs' => $faqs,
                'commentsearchModel' => $commentsearchModel,
                'commentProvider' => $commentProvider,
            ]
        );
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
}
