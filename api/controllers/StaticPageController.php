<?php

namespace api\controllers;

use api\behaviours\Verbcheck;
use api\models\cms\contentmanagement\ContentManagement;
use api\models\cms\faqcategory\FaqCategory;
use api\models\cms\faqs\Faqs;
use Yii;
use yii\filters\AccessControl;

class StaticPageController extends RestController
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
                    'about-us' => ['GET'],
                    'faqs' => ['GET'],
                ],
            ],
        ];
    }


    public function actionAboutUs()
    {
        $content = ContentManagement::findOne(['id' => ContentManagement::CM_ABOUT_US]);
        return Yii::$app->api->sendResponse($data = ['content' => $content['content']], ['message' => "About Us"]);
    }

    public function actionFaqs()
    {
        $faqs = Faqs::find()->where([
            'status' => 1,
        ])->orderby(['sequence' => SORT_ASC, 'question' => SORT_ASC])->all();
        return Yii::$app->api->sendResponse($data = $faqs, ['Faqs']);
    }
}
