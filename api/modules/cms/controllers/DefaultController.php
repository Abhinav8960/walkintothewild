<?php

namespace api\modules\cms\controllers;

use Yii;
use yii\filters\AccessControl;

use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\cms\faqs\FaqsSearch;
use api\models\cms\mastertag\MasterTag;
use api\models\cms\mastertag\MasterTagSearch;


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
                    'master-tag' => ['GET'],
                    'faqs' => ['GET'],
                ],
            ],
        ];
    }


    public function actionMasterTag()
    {
        $searchModel = new MasterTagSearch();
        $searchModel->status =  MasterTagSearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "MasterTag");
    }

    public function actionFaqs()
    {
        $searchModel = new FaqsSearch();
        $searchModel->status =  FaqsSearch::STATUS_ACTIVE;
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "Faqs");
    }

 
}
