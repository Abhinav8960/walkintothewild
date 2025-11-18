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
                'exclude' => ['faqs', 'about-us', 'contact-us'],
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
     *     summary="Get About Us",
     *     description="This API is used to retrieve the detailed About Us page.",
     *       @OA\Response(
     *         response=200,
     *         description="About Us",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="content",
     *                 type="string",
     *                 description="Content",
     *                 example="<p>Walk Into The Wild (WITW) platform &nbsp;is a product of <a href=\'https://mediarc.in/\' target=\'_blank\'>Mediarc Technologies Pvt. Ltd.</a> It has been created by a group of highly skilled and experienced professionals, each with decades of expertise in their respective fields. United by a profound passion for wildlife, these experts aimed to build a platform that brings together wildlife enthusiasts and nature lovers. This platform allows users to create groups to join safaris, making it a cost-effective way to experience wildlife. The platform recommends tiger reserves based on users' preferences and provides detailed information about each reserve. Additionally, users can reach out to multiple tour operators for quotes and choose the best fit for their needs. Acting as India’s 1st wildlife travel network, the portal provides a space where users can share their experiences, connect with like-minded individuals, and plan safaris together. The team is dedicated to continually enhancing the portal with new features that will further benefit the wildlife community and support wildlife conservation efforts.</p></p>"
     *             ),
     *              @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Message",
     *                 example="About Us"
     *             ),
     *         )
     *     ),
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
     *     summary="Get FAQs",
     *     description="This API is used to retrieve the list of FAQs.",
     *
     *     @OA\Response(
     *         response=200,
     *         description="FAQs list retrieved successfully.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=4),
     *                 @OA\Property(property="category_id", type="integer", example=2),
     *                 @OA\Property(property="question", type="string", example="What kind of information is available about tiger reserves?"),
     *                 @OA\Property(property="answer", type="string", example="<p>Each tiger reserve on the platform has a dedicated page with comprehensive details, including how to reach there, safari prices, zones, wildlife highlights, best visiting times, and travel tips.</p>"),
     *                 @OA\Property(property="sequence", type="integer", example=2),
     *                 @OA\Property(property="status", type="integer", example=1)
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
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
     *     description="API for submitting the website contact form, allowing users to send inquiries or messages directly from the site.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name","email", "phone"},
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
     *         description="Query Submitted Successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Query Submitted Successfully!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Token not found")
     *         )
     *     ),
     * )
     */
    public function actionContactUs()
    {
        $model = new ContactForm();
        $model->attributes = $this->request;
        if ($model->validate()) {
            $model->contactquery();
            $message = Yii::$app->api->messageManager->getMessage('common.submitted', ['{var}' => 'Query']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }
    }
}
