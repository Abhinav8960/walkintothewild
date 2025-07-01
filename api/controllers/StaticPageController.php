<?php

namespace api\controllers;

use api\behaviours\Apiauth;
use api\behaviours\Verbcheck;
use api\models\cms\contentmanagement\ContentManagement;
use api\models\cms\faqcategory\FaqCategory;
use api\models\cms\faqs\Faqs;
use api\models\static\form\ContactForm;
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

        return $behaviors +  [
            'apiauth' => [
                'class' => Apiauth::className(),
                'exclude' => ['faqs', 'about-us','contact-us'],
            ],
            // 'access' => [
            //     'class' => AccessControl::className(),
            //     'only' => ['contact-us'],
            //     'rules' => [
            //         [
            //             'actions' => ['contact-us'],
            //             'allow' => true,
            //             'roles' => ['@'],
            //         ],

            //     ],
            // ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'about-us' => ['GET'],
                    'faqs' => ['GET'],
                    'contact-us' => ['POST'],
                ],
            ],
        ];
    }


    public function actionAboutUs()
    {
        $content = ContentManagement::findOne(['id' => ContentManagement::CM_ABOUT_US]);
        $message = Yii::$app->api->messageManager->getMessage('common.about_us');
        return Yii::$app->api->sendResponse($data = ['content' => $content['content']], ['message' => $message]);
    }

    public function actionFaqs()
    {
        $faqs = Faqs::find()->where([
            'status' => 1,
        ])->orderby(['sequence' => SORT_ASC, 'question' => SORT_ASC])->all();
        return Yii::$app->api->sendResponse($data = $faqs);
    }

    public function actionContactUs()
    {
        $model = new ContactForm();
        $model->attributes = $this->request;
        if ($model->validate()) {
            $model->contactquery();
            $message = Yii::$app->api->messageManager->getMessage('common.submitted',['{var}'=> 'Query']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
    }
}
