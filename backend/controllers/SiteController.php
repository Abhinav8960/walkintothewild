<?php

namespace backend\controllers;

use api\components\Api;
use api\components\MessageManager;
use backend\components\AuthHandler;
use common\interfaces\StatusInterface;
use common\models\cms\blog\Blog;
use common\models\operator\OperatorQuote;
use common\models\operator\SafariOperator;
use common\models\package\Package;
use common\models\package\PackageQuote;
use common\models\sharesafari\ShareSafari;
use common\models\LoginForm;
use common\models\MailLog;
use common\models\operator\SafariOperatorRating;
use common\models\package\PackageVersion;
use common\models\package\PackageVersionSearch;
use common\models\park\SafariParkRating;
use common\models\sharesafari\ShareSafariVersion;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
// use common\models\trierror\BackendErrorLog;
// use common\models\trierror\form\BackendErrorLogForm;
use common\models\trierror\form\ErrorLogForm;
use common\models\urlshortner\UrlShortner;
use Google\Auth\CredentialSource\UrlSource;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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

        return $this->render('index', ['package_model' => $package_model, 'fixed_departure_model' => $fixed_departure_model, 'operator_review_model' => $operator_review_model, 'park_review_model' => $park_review_model]);
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

        throw new NotFoundHttpException('Short URL not found.');
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
            Yii::$app->session->setFlash('success', 'Payment successful!');
        } else {
            // Handle failure response
            Yii::$app->session->setFlash('error', 'Payment failed or cancelled.');
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

        Yii::$app->session->setFlash('success', 'Cache cleared successfully.');
        return $this->redirect(['index']);
    }
}
