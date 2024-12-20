<?php

namespace api\modules\meta\controllers;

use Yii;
use yii\filters\AccessControl;

use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\meta\MetaAccommodationSearch;
use api\models\meta\MetaAnimalTypeSearch;
use api\models\meta\MetaBirdTypeSearch;
use api\models\meta\MetaLocationSearch;
use api\models\meta\MetaOperatorCredibilitySearch;
use api\models\meta\MetaOtherWildlifeActivitiesSearch;
use api\models\meta\MetaPackageRangeSearch;
use api\models\meta\MetaParkTripSlotSearch;
use api\models\meta\MetaSafariSessionSearch;
use api\models\meta\MetaStayCategorySearch;
use api\models\meta\MetaTermConditionTypeSearch;
use api\models\meta\MetaZoneTypeSearch;

/**
 * Site controller
 */
class DefaultController extends RestController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'all' => ['GET'],
                    'accommodation' => ['GET'],
                    'animal-type' => ['GET'],
                    'bird-type' => ['GET'],
                    'location' => ['GET'],
                    'operator-credibility' => ['GET'],
                    'other-wildlife-activities' => ['GET'],
                    'package-range' => ['GET'],
                    'park-trip-slot' => ['GET'],
                    'safari-session' => ['GET'],
                    'stay-category' => ['GET'],
                    'term-condition-type' => ['GET'],
                    'zone-type' => ['GET'],

                ],
            ],
        ];
    }


    private function readFolderAndFiles($directory)
    {
        if (!is_dir($directory)) {
            echo "Error: $directory is not a valid directory.\n";
            return;
        }

        $fileContent = [];

        $files = scandir($directory);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $filePath = $directory . '/' . $file;
            if (is_dir($filePath)) {
                $this->readFolderAndFiles($filePath); // Recursively read subdirectories
            } else {
                $content =  file_get_contents($filePath);
                $fileContent[] = json_decode($content, true);
            }
        }
        return $fileContent;
    }

    public function actionAll()
    {

        $directory = Yii::getAlias('@app') . '/web/json';
        $data = $this->readFolderAndFiles($directory);

        return Yii::$app->api->sendResponse($data);
    }

    public function actionAccommodation()
    {
        $searchModel = new MetaAccommodationSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaAccommodation");
    }

    public function actionAnimalType()
    {
        $searchModel = new MetaAnimalTypeSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaAnimalType");
    }

    public function actionBirdType()
    {
        $searchModel = new MetaBirdTypeSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaBirdType");
    }

    public function actionLocation()
    {
        $searchModel = new MetaLocationSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaLocation");
    }

    public function actionOperatorCredibility()
    {
        $searchModel = new MetaOperatorCredibilitySearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaOperatorCredibility");
    }

    public function actionOtherWildlifeActivities()
    {
        $searchModel = new MetaOtherWildlifeActivitiesSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaOtherWildlifeActivities");
    }

    public function actionPackageRange()
    {
        $searchModel = new MetaPackageRangeSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaPackageRange");
    }

    public function actionParkTripSlot()
    {
        $searchModel = new MetaParkTripSlotSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaParkTripSlot");
    }

    public function actionSafariSession()
    {
        $searchModel = new MetaSafariSessionSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaSafariSession");
    }



    public function actionStayCategory()
    {
        $searchModel = new MetaStayCategorySearch();
        $searchModel->status = 1;
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaStayCategory");
    }

    public function actionTermConditionType()
    {
        $searchModel = new MetaTermConditionTypeSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaTermConditionType");
    }

    public function actionZoneType()
    {
        $searchModel = new MetaZoneTypeSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "MetaZoneType");
    }
}
