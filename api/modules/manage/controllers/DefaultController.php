<?php

namespace api\modules\manage\controllers;

use api\behaviours\Apiauth;
use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\operator\SafariOperator;
use api\models\package\PackageVersionSearch;
use api\models\sharesafari\ShareSafari;
use api\models\sharesafari\ShareSafariSearch;
use common\interfaces\NewStatusInterface;
use common\models\operator\form\SafariOperatorRequestForm;
use common\models\package\PackagePartnerSearch;
use common\models\registration\SafariOperatorRequest;
use common\models\registration\SafariOperatorRequestActivities;
use common\models\registration\SafariOperatorRequestPark;
use Yii;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * Default controller for the `manage` module
 */
class DefaultController extends RestController
{
    public $action_ids = ['index'];

    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
            'apiauth' => [
                'class' => Apiauth::className(),
                'exclude' => [],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'operator-safarilist', 'operator-packagelist'],
                'rules' => [
                    [
                        'actions' => ['index', 'operator-safarilist', 'operator-packagelist'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'index' => ['GET'],
                    'operator-safarilist' => ['GET'],
                    'operator-packagelist' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Get Operator Detail
     *
     * @OA\Get(
     *     path="/manage",
     *     tags={"Manage"},
     *     summary="Get Operator Detail",
     *     description="Allows to get the operator details along with their operated parks.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Operator Details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", ref="#/components/schemas/PartnerDetailSchema")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Operator not found.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Operator Not Found!!!"
     *             )
     *         )
     *     )
     * )
     */

    public function actionIndex()
    {
        $this->layout = \common\interfaces\NewStatusInterface::OPERATOR_API_LAYOUT_FULL;
        $safari_operator = $this->module->operatormodel();
        $data['data'] = $safari_operator;
        return Yii::$app->api->sendResponse($data);
    }


    // public function actionEditRequest()
    // {
    //     return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);

    //     $safari_operator = $this->module->operatormodel();
    //     $safari_operator_id = $safari_operator->id;

    //     $safari_operator_model = SafariOperator::find()->where(['id' => $safari_operator_id])->limit(1)->one();
    //     $model = new SafariOperatorRequestForm($safari_operator_model);
    //     $model->user_id = $safari_operator->user_id;
    //     $model->status = SafariOperator::STATUS_ACTIVE;
    //     //     $model->action_url = '/manage/default/edit-request';
    //     //     $model->action_validate_url = '/manage/default/validate';
    //     $model->referrer_url = \Yii::$app->request->referrer;

    //     $model->attributes = $this->request;
    //     $model->logo = UploadedFile::getInstanceByName('logo');
    //     if ($model->validate()) {
    //         $model->initializeForm();

    //         // Revome All Previouse Request if Any Pending for Approval
    //         SafariOperatorRequest::updateAll(['status' => NewStatusInterface::STATUS_DELETE], ['safari_operator_id' => $safari_operator_model->id, 'status' => 1, 'is_approved' => 0]);

    //         if ($model->safari_operator_request_model->save(false)) {
    //             $model->uploadFile();
    //             $parks = $model->park_id;
    //             SafariOperatorRequestPark::updateAll(['status' => 0], ['safari_operator_request_id' => $model->safari_operator_request_model->id]);
    //             if ($parks) {
    //                 foreach ($parks as $park) {
    //                     $safarioperatorrequestpark = new SafariOperatorRequestPark();
    //                     $safarioperatorrequestpark->safari_operator_request_id = $model->safari_operator_request_model->id;
    //                     $safarioperatorrequestpark->park_id = $park;
    //                     $safarioperatorrequestpark->save(false);
    //                 }
    //             }


    //             $activities = $model->offers_other_wildlifeactivities;
    //             SafariOperatorRequestActivities::updateAll(['status' => 0], ['safari_operator_request_id' => $model->safari_operator_request_model->id]);
    //             if ($activities) {
    //                 foreach ($activities as $activity) {
    //                     $safarioperatorrequestactivity = new SafariOperatorRequestActivities();
    //                     $safarioperatorrequestactivity->safari_operator_request_id = $model->safari_operator_request_model->id;
    //                     $safarioperatorrequestactivity->wildlife_activity_id = $activity;
    //                     $safarioperatorrequestactivity->save(false);
    //                 }
    //             }

    //             // $to_mail = $model->safari_operator_request_model->email;
    //             // $subject = 'Information Update Successfully!';
    //             // $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_SAFARI_OPERATOR_REGISTRATION;
    //             // $req = ['username' => $model->safari_operator_request_model->business_name];

    //             // MailLog::createMailLog($to_mail, $subject, $template, $req, []);
    //             // \Yii::$app->session->setFlash('success', 'Safari Operator Update Request Sent Successfully, Please Wait Until Approval');
    //             // return $this->redirect(['index']);
    //             $model->safari_operator_request_model->is_approved = 1;
    //             if ($model->safari_operator_request_model->save(false)) {
    //                 $safari_operator = $model->safari_operator_request_model->safariapproved($model->safari_operator_request_model);
    //                 if ($safari_operator) {
    //                     return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Information Updated Successfully"]);
    //                 }
    //             }
    //         }
    //     }
    //     return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    // }

    /**
     * Validate Safari Operator Edit Form
     */
    // public function actionValidate()
    // {
    //     $safari_operator = $this->module->operatormodel();
    //     $model = new SafariOperatorRequestForm($safari_operator);

    //     if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
    //         Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    //         return \yii\widgets\ActiveForm::validate($model);
    //     }
    // }

    /**
     * Business Request
     */
    // public function actionViewrequest($id = null)
    // {
    //     $safari_operator = $this->module->operatormodel();
    //     $user = Yii::$app->user->identity;
    //     $business_request = SafariOperatorRequest::find()->where(['user_id' => $user->id])->andFilterWhere(['id' => $id])->orderby(['id' => SORT_DESC])->one();
    //     if (!$business_request) {
    //         Yii::$app->session->setFlash('success', 'No Business Request Found!');
    //         return $this->redirect(['index']);
    //     }

    //     return $this->render('viewrequest', [
    //         'user' => $user,
    //         'safari_operator_request' => $business_request,
    //         'safari_operator' => $safari_operator
    //     ]);
    // }

    /**
     * Get Fixed Departure List
     *
     * @OA\Get(
     *     path="/manage/operator-safarilist",
     *     tags={"Manage"},
     *     summary="Get Fixed Departure List",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operator Safarilist",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="share_safari",
     *                 type="object",
     *                 @OA\Property(property="summary", ref="#/components/schemas/SummarySchema"),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/ShareSafariViewSchema")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Safari List Not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Safari List Not Found")
     *         )
     *     )
     * )
     */
    public function actionOperatorSafarilist()
    {
        $safari_operator = $this->module->operatormodel();
        $searchModel = new ShareSafariSearch();
        $searchModel->status = 1;
        return $this->dataProviderSender($searchModel, $rootIndexName = "share_safari", $additionalSearchQueryParams = [$safari_operator->id], $singleRecord = false, $paginationNeededAsPerQuery = 1, $searchfunction = "managesearch");
    }


    /**
     * Get Package List
     *
     * @OA\Get(
     *     path="/manage/operator-packagelist",
     *     tags={"Manage"},
     *     summary="Get Package List",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operator Packagelist",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="packages",
     *                 type="object",
     *                 @OA\Property(property="summary", ref="#/components/schemas/SummarySchema"),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/PackageViewSchema")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Package List Not Found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Package List Not Found")
     *         )
     *     )
     * )
     */


    public function actionOperatorPackagelist()
    {
        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {
            $message = Yii::$app->api->messageManager->getMessage('common.not_operator');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        $searchModel = new PackagePartnerSearch();
        $searchModel->safari_operator_id = $safari_operator->id;
        $searchModel->custom_status = 1;
        return $this->dataProviderSender($searchModel, $rootIndexName = "packages", $additionalSearchQueryParams = [], $singleRecord = false, $paginationNeededAsPerQuery = 1, $searchfunction = "managesearch");
    }

    public function actionView($slug)
    {
        $safari_operator = $this->module->operatormodel();
        $this->layout = \common\interfaces\NewStatusInterface::SHARE_SAFARI_API_LAYOUT_FULL;
        $share_safari = ShareSafari::find()->where(['slug' => $slug, 'host_user_id' => $safari_operator->id])->limit(1)->one();

        if (!$share_safari) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Share Safari Not Found!!!"]);
        }

        if (!in_array($share_safari->status, [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT])) {
            return Yii::$app->api->sendResponse($data = ['data' => $share_safari], ['message' => "Share Safari is not in use!!!"]);
        }

        if ($share_safari->start_date < date('Y-m-d')) {
            return Yii::$app->api->sendResponse($data = ['data' => $share_safari], ['message' => "Share Safari Expired!!!"]);
        }

        return Yii::$app->api->sendResponse($data = ['data' => $share_safari]);
    }
}
