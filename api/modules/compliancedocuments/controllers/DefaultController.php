<?php

namespace api\modules\compliancedocuments\controllers;

use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\compliancedocuments\ComplianceDocumentsSearch;
use Yii;


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
                    'index' => ['GET'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $searchModel = new ComplianceDocumentsSearch();
        $searchModel->status =  ComplianceDocumentsSearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "Compliance Documents");
    }
}
