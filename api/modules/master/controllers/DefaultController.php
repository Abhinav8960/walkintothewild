<?php

namespace api\modules\master\controllers;

use Yii;
use yii\filters\AccessControl;

use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\master\airport\MasterAirportSearch;
use api\models\master\animal\MasterAnimalSearch;
use api\models\master\bird\MasterBirdSearch;
use api\models\master\bonusexperience\MasterBonusExperienceSearch;
use api\models\master\city\MasterCitySearch;
use api\models\master\country\MasterCountrySearch;
use api\models\master\faq\MasterFaqSearch;
use api\models\master\location\MasterLocationSearch;
use api\models\master\message\MasterMessageSearch;
use api\models\master\month\MasterMonthSearch;
use api\models\master\operatorcategory\MasterOperatorCategorySearch;
use api\models\master\packagefeature\MasterPackagefeatureSearch;
use api\models\master\packageinclude\MasterPackageIncludeSearch;
use api\models\master\railwaystation\MasterRailwayStationSearch;
use api\models\master\sharesafarireason\MasterShareSafariReasonSearch;
use api\models\master\state\MasterStateSearch;
use api\models\master\suggetioncategory\MasterSuggestionCategorySearch;
use api\models\master\vehicle\MasterVehicleSearch;
use api\models\meta\MetaAccommodationSearch;
use common\models\GeneralModel;

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
                    'airport' => ['GET'],
                    'animal' => ['GET'],
                    'bird' => ['GET'],
                    'bonus-experience' => ['GET'],
                    'city' => ['GET'],
                    'country' => ['GET'],
                    'faq' => ['GET'],
                    'location' => ['GET'],
                    'month' => ['GET'],
                    'operator-category' => ['GET'],
                    'package-feature' => ['GET'],
                    'package-include' => ['GET'],
                    'railway-station' => ['GET'],
                    'share-safari-reason' => ['GET'],
                    'state' => ['GET'],
                    'suggestion-category' => ['GET'],
                    'vehicle' => ['GET'],
                    'privacy-options' => ['GET'],
                    
                ],
            ],
        ];
    }


    public function actionAirport()
    {
        $searchModel = new MasterAirportSearch();
        $searchModel->status =  MasterAirportSearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "master_airport");
    }

    public function actionAnimal()
    {
        $searchModel = new MasterAnimalSearch();
        $searchModel->status =  MasterAnimalSearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "master_animal");
    }

    public function actionBird()
    {
        $searchModel = new MasterBirdSearch();
        $searchModel->status =  MasterBirdSearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "master_bird");
    }

    public function actionBonusExperience()
    {
        $searchModel = new MasterBonusExperienceSearch();
        $searchModel->status =  MasterBonusExperienceSearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "master_bonus_experience");
    }

    public function actionCity()
    {
        $searchModel = new MasterCitySearch();
        $searchModel->status =  MasterCitySearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "master_city");
    }

    public function actionCountry()
    {
        $searchModel = new MasterCountrySearch();
        $searchModel->status =  MasterCountrySearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "master_country");
    }

    public function actionFaq()
    {
        $searchModel = new MasterFaqSearch();
        $searchModel->status =  MasterFaqSearch::STATUS_ACTIVE;
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "master_faq");
    }

    public function actionLocation()
    {
        $searchModel = new MasterLocationSearch();
        $searchModel->status =  MasterLocationSearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "master_location");
    }

    public function actionMonth()
    {
        $searchModel = new MasterMonthSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "master_month");
    }

    public function actionOperatorCategory()
    {
        $searchModel = new MasterOperatorCategorySearch();
        $searchModel->status =  MasterOperatorCategorySearch::STATUS_ACTIVE;

        return $this->dataProviderSender($searchModel, $rootIndexName = "master_operator_category");
    }

    public function actionPackageFeature()
    {
        $searchModel = new MasterPackagefeatureSearch();
        $searchModel->status =  MasterPackagefeatureSearch::STATUS_ACTIVE;

        return $this->dataProviderSender($searchModel, $rootIndexName = "master_package_feature");
    }

    public function actionPackageInclude()
    {
        $searchModel = new MasterPackageIncludeSearch();
        $searchModel->status =  MasterPackageIncludeSearch::STATUS_ACTIVE;

        return $this->dataProviderSender($searchModel, $rootIndexName = "master_package_include");
    }

    public function actionRailwayStation()
    {
        // ini_set("memory_limit", "-1");
        $searchModel = new MasterRailwayStationSearch();
        $searchModel->status =  MasterRailwayStationSearch::STATUS_ACTIVE;

        return $this->dataProviderSender($searchModel, $rootIndexName = "master_railway_station");
    }

    public function actionShareSafariReason()
    {
        $searchModel = new MasterShareSafariReasonSearch();
        $searchModel->status =  MasterShareSafariReasonSearch::STATUS_ACTIVE;

        return $this->dataProviderSender($searchModel, $rootIndexName = "master_share_safari_reason");
    }


    public function actionState()
    {
        $searchModel = new MasterStateSearch();
        $searchModel->status =  MasterStateSearch::STATUS_ACTIVE;

        return $this->dataProviderSender($searchModel, $rootIndexName = "master_state");
    }

    public function actionSuggestionCategory()
    {
        $searchModel = new MasterSuggestionCategorySearch();
        $searchModel->status =  MasterSuggestionCategorySearch::STATUS_ACTIVE;

        return $this->dataProviderSender($searchModel, $rootIndexName = "master_suggestion_category");
    }

    public function actionVehicle()
    {
        $searchModel = new MasterVehicleSearch();
        $searchModel->status =  MasterVehicleSearch::STATUS_ACTIVE;

        return $this->dataProviderSender($searchModel, $rootIndexName = "master_vehicle");
    }

    public function actionPrivacyOptions(){
        $options = GeneralModel::privacyoptions();

       return $this->dataSender($options, 'privacy_options');
    }
}
