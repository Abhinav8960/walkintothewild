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

     /**
     * 
     * Get About Us
     *
     *
     * @OA\Get(
     *     path="/about-us",
     *     tags={"Static"},
     *     summary="Get About Us (Draft)",
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     ),
     * )
     */
    public function actionAboutUs()
    {
        $content = ContentManagement::findOne(['id' => ContentManagement::CM_ABOUT_US]);
        $message = Yii::$app->api->messageManager->getMessage('common.about_us');
        return Yii::$app->api->sendResponse($data = ['content' => $content['content']], ['message' => $message]);
    }

      /**
     * 
     * Get Faqs
     *
     *
     * @OA\Get(
     *     path="/faqs",
     *     tags={"Static"},
     *     summary="Get Faqs (Draft)",
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     ),
     * )
     */
    public function actionFaqs()
    {
        $faqs = Faqs::find()->where([
            'status' => 1,
        ])->orderby(['sequence' => SORT_ASC, 'question' => SORT_ASC])->asArray()->all();
        return Yii::$app->api->sendResponse($data = $faqs);
    }

     /**
     * 
     * Contact Form
     *
     * Allows users to contact.
     *
     * @OA\Post(
     *     path="/contact-us",
     *     tags={"Static"},
     *     summary="Contact Form",
     *     description="Allows users to contact",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name","email", "message", "phone"},
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="Enter Name",
     *                     example=""
     *                 ),
     *                  @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     description="Enter Email",
     *                     example=""
     *                 ),
     *                  @OA\Property(
     *                     property="phone",
     *                     type="integer",
     *                     description="Enter Phone Number",
     *                     example=""
     *                 ),
     *                  @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     description="Enter Message",
     *                     example=""
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Query Submitted successfully!"
     *     )
     * )
     */
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
