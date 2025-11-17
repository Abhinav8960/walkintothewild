<?php

namespace backend\controllers;

use Yii;
use yii\web\Response;
use api\components\Api;
use yii\web\Controller;
use common\models\SmsLog;
use common\models\CallLog;
use common\models\MailLog;
use yii\filters\VerbFilter;
use common\models\LoginForm;
use yii\filters\AccessControl;
use common\models\cms\blog\Blog;
use api\components\MessageManager;
use common\models\package\Package;
use yii\web\NotFoundHttpException;
use backend\components\AuthHandler;
use common\interfaces\StatusInterface;
use common\models\package\PackageQuote;
use common\models\park\SafariParkRating;
use common\models\operator\OperatorQuote;
use common\models\package\PackageComment;
use common\models\package\PackageVersion;
use common\models\operator\SafariOperator;
use common\models\sharesafari\ShareSafari;
use common\models\urlshortner\UrlShortner;
use common\models\sighting\SightingComment;
use Google\Auth\CredentialSource\UrlSource;
// use common\models\trierror\BackendErrorLog;
// use common\models\trierror\form\BackendErrorLogForm;
use common\models\trierror\form\ErrorLogForm;
use common\models\package\PackageVersionSearch;
use common\models\postscomment\UserPostComment;
use common\models\operator\SafariOperatorRating;
use common\models\partnergallery\PartnerGallery;
use common\models\sharesafari\ShareSafariComment;
use common\models\sharesafari\ShareSafariVersion;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'auth', 'redirect', 'redirect-url'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'auth', 'clear-cache'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                    'payu-response' => ['post', 'get'],
                ],
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $package_model = PackageVersion::find()->where(['status' => PackageVersion::SEND_FOR_APPROVAL_STATUS])->count();
        $fixed_departure_model = ShareSafariVersion::find()->where(['status' => ShareSafariVersion::SEND_FOR_APPROVAL_STATUS])->count();
        $operator_review_model = SafariOperatorRating::find()->where(['status' => SafariOperatorRating::STATUS_CREATE])->count();
        $park_review_model = SafariParkRating::find()->where(['status' => SafariParkRating::STATUS_SUSPEND])->count();
        $gallery_model = PartnerGallery::find()->where(['IN', 'listing_status', [10, 1]])->andWhere(['edit_status' => 2])->count();
        $post_model = UserPostComment::find()->where(['flaged' => 1, 'deleted_by' => 0])->count();
        $sighting_model = SightingComment::find()->where(['flaged' => 1, 'deleted_by' => 0])->count();
        $share_safari_flag_model = ShareSafariComment::find()->where(['flaged' => 1, 'deleted_by' => 0])->count();
        $package_flag_model = PackageComment::find()->where(['flaged' => 1])->andWhere(['deleted_by' => 0])->count();

        $last_sms_status = SmsLog::find()->orderby(['id' => SORT_DESC])->one();
        $last_call_status = CallLog::find()->orderby(['id' => SORT_DESC])->one();

        return $this->render('index', [
            'package_model' => $package_model,
            'fixed_departure_model' => $fixed_departure_model,
            'operator_review_model' => $operator_review_model,
            'park_review_model' => $park_review_model,
            'gallery_model' => $gallery_model,
            'post_model' => $post_model,
            'sighting_model' => $sighting_model,
            'share_safari_flag_mmodel' => $share_safari_flag_model,
            'package_flag_model' => $package_flag_model,
            'last_sms_status' => $last_sms_status,
            'last_call_status' => $last_call_status,
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = $model->user;
            // echo '<pre>';
            // print_r($user);
            // die();
            $to_mail = $user->email;
            $subject = 'User Login';
            $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_LOGIN;
            $req = ['username' => $user->name, 'is_email_sending' => true];

            MailLog::createMailLog($to_mail, $subject, $template, $req, []);

            return $this->goBack();
        }

        $model->password = '';

        return $this->render('@frontend/views/site/signin_backend', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        $session = Yii::$app->session;
        if ($session->get('user_session_id')) {
            Yii::$app
                ->db
                ->createCommand()
                ->delete('user_session', ['id' => $session->get('user_session_id')])
                ->execute();
            $session->remove('user_session_id');
        }
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }

    /**
     * Redirect Url to another link
     */
    public function actionRedirect()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($userAgent, 'Instagram')) {
            header('Content-type: application/pdf');
            header('Content-Disposition: inline; filename=tmp');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');
            @readfile('tmp');
        } else {
            $this->redirect(Yii::$app->request->referrer);
        }
    }

    /*
     * public function actionError()
     * {
     *     $exception = Yii::$app->errorHandler->exception;
     *
     *     $request = Yii::$app->request;
     *     $user_session_id = Yii::$app->user->id;
     *     $error_type = $exception->statusCode;
     *     $error_msg = $exception->getMessage();
     *     $pathInfo = $request->pathInfo;
     *     $source = $request->userAgent;
     *     $request_url = $request->absoluteUrl;
     *     $reference_url = $request->referrer;
     *     $method = $request->getMethod();
     *     $ip_address = $request->getRemoteIP();
     *     $error_model = new BackendErrorLogForm();
     *     $error_model->scenario = 'create';
     *     $error_model->backend_errorlog->setAttributes([
     *         'error_type'            => $error_type,
     *         'request_url'           => $request_url,
     *         'reference_url'         => $reference_url,
     *         'ip_address'            => $ip_address,
     *         'request_type'          => $method,
     *         'error_msg'             => $error_msg,
     *         'user_session_id'       => $user_session_id,
     *         'source'                => $source,
     *         'user_agent'            => Yii::$app->request->userAgent,
     *     ]);
     *     $error_model->backend_errorlog->save(false);
     *
     *     return $this->render(
     *         'error',
     *         [
     *             'name' => $exception->getMessage() . '(#' . $exception->statusCode . ')',
     *             'message' => $exception->getMessage(),
     *             'exception' => $exception
     *         ]
     *     );
     * }
     */

    public function actionRedirectUrl($short_id)
    {
        $url = UrlShortner::findOne(['short_id' => $short_id, 'status' => 1]);

        if ($url) {
            $url->incrementClick();
            $url->urlshortnerlog();
            if ($url->one_time_valid == 1) {
                $url->status = UrlShortner::STATUS_DELETE;
                $url->save(false);
                return $this->redirect($url->shortner_url, $url->code ?? '302');
            }
            return $this->redirect($url->shortner_url, $url->code ?? '302');
        }
        $message = Yii::$app->messageManager->getMessage('common.not_found', ['{var}' => 'Short URL']);
        throw new NotFoundHttpException($message);
    }

    // 'successUrl' => 'http://admin.walkintothewild.io/payu/success',
    // 'failureUrl' => 'http://admin.walkintothewild.io/payu/failure',
    // 'cancelUrl' => 'http://app.walkintothewild.io/payu/cancel',

    public function actionPayuResponse()
    {
        $data = Yii::$app->request->post();

        \Yii::info('PayU Response: ' . json_encode($data), 'payu');

        if (isset($data['status']) && $data['status'] == 'success') {
            // Handle success response
            // You can process the payment details here
            $message = Yii::$app->messageManager->getMessage('payment.payment_success');
            Yii::$app->session->setFlash('success', $message);
        } else {
            // Handle failure response
            $message = Yii::$app->messageManager->getMessage('payment.pament_failed');
            Yii::$app->session->setFlash('error', $message);
        }

        return $this->redirect(Yii::$app->params['partner_url'] . '/payu-response/' . $data['txnid']);
    }
    // public function actionClearCache()
    // {
    //     MessageManager::clearAllCache();
    //     Yii::$app->session->setFlash('success', 'Cache cleared successfully.');
    //     return $this->redirect(['index']);
    // }

    public function actionClearCache()
    {
        $cachePaths = [
            '@api/runtime/message-cache',
            // '@business/runtime/cache',
            // '@backend/runtime/cache',
        ];
        foreach ($cachePaths as $path) {
            $cache = new \yii\caching\FileCache([
                'cachePath' => Yii::getAlias($path),
            ]);
            $manager = new \api\components\MessageManager();
            $manager->clearCache($cache);
        }
        $message = Yii::$app->messageManager->getMessage('common.cache_cleared');
        Yii::$app->session->setFlash('success', $message);
        return $this->redirect(['index']);
    }
}
