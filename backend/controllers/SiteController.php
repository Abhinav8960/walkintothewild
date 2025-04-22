<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\components\AuthHandler;
use common\interfaces\StatusInterface;
use common\models\cms\blog\Blog;
use common\models\MailLog;
use common\models\operator\OperatorQuote;
use common\models\operator\SafariOperator;
use common\models\package\Package;
use common\models\package\PackageQuote;
use common\models\sharesafari\ShareSafari;
//use common\models\trierror\BackendErrorLog;
//use common\models\trierror\form\BackendErrorLogForm;
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
                        'actions' => ['logout', 'index', 'auth'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
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
        $today_start = strtotime('today 00:00:00');
        $today_end = strtotime('today 23:59:59');

        $startOfWeek = strtotime('monday this week 00:00:00');
        $endOfWeek = strtotime('sunday this week 23:59:59');

        $startOfMonth = strtotime('first day of this month 00:00:00');
        $endOfMonth = strtotime('last day of this month 23:59:59');

        $startOfLastMonth = strtotime('first day of last month 00:00:00');
        $endOfLastMonth = strtotime('last day of last month 23:59:59');

        $todaynew_operator = SafariOperator::find()
            ->where(['between', 'created_at', $today_start, $today_end])->andWhere(['status' => SafariOperator::STATUS_ACTIVE])
            ->count();

        $thisweek_new_operator = SafariOperator::find()
            ->where(['between', 'created_at', $startOfWeek, $endOfWeek])->andWhere(['status' => SafariOperator::STATUS_ACTIVE])
            ->count();

        $thismonth_new_operator = SafariOperator::find()
            ->where(['between', 'created_at', $startOfMonth, $endOfMonth])->andWhere(['status' => SafariOperator::STATUS_ACTIVE])
            ->count();

        $lastmonth_new_operator = SafariOperator::find()
            ->where(['between', 'created_at', $startOfLastMonth, $endOfLastMonth])->andWhere(['status' => SafariOperator::STATUS_ACTIVE])
            ->count();

        $total_new_operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE])->count();



        $todayoperator_request_quote = OperatorQuote::find()
            ->where(['between', 'created_at', $today_start, $today_end])->andWhere(['status' => OperatorQuote::STATUS_ACTIVE])
            ->count();

        $thisweek_operator_request_quote = OperatorQuote::find()
            ->where(['between', 'created_at', $startOfWeek, $endOfWeek])->andWhere(['status' => OperatorQuote::STATUS_ACTIVE])
            ->count();

        $thismonth_operator_request_quote = OperatorQuote::find()
            ->where(['between', 'created_at', $startOfMonth, $endOfMonth])->andWhere(['status' => OperatorQuote::STATUS_ACTIVE])
            ->count();

        $lastmonth_operator_request_quote = OperatorQuote::find()
            ->where(['between', 'created_at', $startOfLastMonth, $endOfLastMonth])->andWhere(['status' => OperatorQuote::STATUS_ACTIVE])
            ->count();

        $total_operator_request_quote = OperatorQuote::find()->where(['status' => OperatorQuote::STATUS_ACTIVE])->count();


        $todaynew_package = Package::find()
            ->where(['between', 'created_at', $today_start, $today_end])->andWhere(['status' => Package::APPROVED_AND_LIVE_STATUS])
            ->count();

        $thisweek_new_package = Package::find()
            ->where(['between', 'created_at', $startOfWeek, $endOfWeek])->andWhere(['status' => Package::APPROVED_AND_LIVE_STATUS])
            ->count();

        $thismonth_new_package = Package::find()
            ->where(['between', 'created_at', $startOfMonth, $endOfMonth])->andWhere(['status' => Package::APPROVED_AND_LIVE_STATUS])
            ->count();

        $lastmonth_new_package = Package::find()
            ->where(['between', 'created_at', $startOfLastMonth, $endOfLastMonth])->andWhere(['status' => Package::APPROVED_AND_LIVE_STATUS])
            ->count();

        $total_new_package = Package::find()->where(['status' => Package::APPROVED_AND_LIVE_STATUS])->count();


        $todaypackage_request_quote = PackageQuote::find()
            ->where(['between', 'created_at', $today_start, $today_end])->andWhere(['status' => PackageQuote::STATUS_ACTIVE])
            ->count();

        $thisweek_package_request_quote = PackageQuote::find()
            ->where(['between', 'created_at', $startOfWeek, $endOfWeek])->andWhere(['status' => PackageQuote::STATUS_ACTIVE])
            ->count();

        $thismonth_package_request_quote = PackageQuote::find()
            ->where(['between', 'created_at', $startOfMonth, $endOfMonth])->andWhere(['status' => PackageQuote::STATUS_ACTIVE])
            ->count();

        $lastmonth_package_request_quote = PackageQuote::find()
            ->where(['between', 'created_at', $startOfLastMonth, $endOfLastMonth])->andWhere(['status' => PackageQuote::STATUS_ACTIVE])
            ->count();

        $total_package_request_quote = PackageQuote::find()->where(['status' => PackageQuote::STATUS_ACTIVE])->count();



        $todaynew_share_safari = ShareSafari::find()
            ->where(['between', 'created_at', $today_start, $today_end])->andWhere(['status' => ShareSafari::STATUS_ACTIVE, 'type' => 1])
            ->count();

        $thisweek_new_share_safari = ShareSafari::find()
            ->where(['between', 'created_at', $startOfWeek, $endOfWeek])->andWhere(['status' => ShareSafari::STATUS_ACTIVE, 'type' => 1])
            ->count();

        $thismonth_new_share_safari = ShareSafari::find()
            ->where(['between', 'created_at', $startOfMonth, $endOfMonth])->andWhere(['status' => ShareSafari::STATUS_ACTIVE, 'type' => 1])
            ->count();

        $lastmonth_new_share_safari = ShareSafari::find()
            ->where(['between', 'created_at', $startOfLastMonth, $endOfLastMonth])->andWhere(['status' => ShareSafari::STATUS_ACTIVE, 'type' => 1])
            ->count();

        $total_new_share_safari = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE, 'type' => 1])->count();



        $todaynew_fixed_departure = ShareSafari::find()
            ->where(['between', 'created_at', $today_start, $today_end])->andWhere(['status' => ShareSafari::STATUS_ACTIVE, 'type' => 2])
            ->count();

        $thisweek_new_fixed_departure = ShareSafari::find()
            ->where(['between', 'created_at', $startOfWeek, $endOfWeek])->andWhere(['status' => ShareSafari::STATUS_ACTIVE, 'type' => 2])
            ->count();

        $thismonth_new_fixed_departure = ShareSafari::find()
            ->where(['between', 'created_at', $startOfMonth, $endOfMonth])->andWhere(['status' => ShareSafari::STATUS_ACTIVE, 'type' => 2])
            ->count();

        $lastmonth_new_fixed_departure = ShareSafari::find()
            ->where(['between', 'created_at', $startOfLastMonth, $endOfLastMonth])->andWhere(['status' => ShareSafari::STATUS_ACTIVE, 'type' => 2])
            ->count();

        $total_new_fixed_departure = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE, 'type' => 2])->count();



        $todaynew_blog = Blog::find()
            ->where(['between', 'created_at', $today_start, $today_end])->andWhere(['status' => Blog::STATUS_ACTIVE])
            ->count();

        $thisweek_new_blog = Blog::find()
            ->where(['between', 'created_at', $startOfWeek, $endOfWeek])->andWhere(['status' => Blog::STATUS_ACTIVE])
            ->count();

        $thismonth_new_blog = Blog::find()
            ->where(['between', 'created_at', $startOfMonth, $endOfMonth])->andWhere(['status' => Blog::STATUS_ACTIVE])
            ->count();

        $lastmonth_new_blog = Blog::find()
            ->where(['between', 'created_at', $startOfLastMonth, $endOfLastMonth])->andWhere(['status' => Blog::STATUS_ACTIVE])
            ->count();

        $total_new_blog = Blog::find()->where(['status' => Blog::STATUS_ACTIVE])->count();



        return $this->render('index', [
            'todaynew_operator' => $todaynew_operator,
            'thisweek_new_operator' => $thisweek_new_operator,
            'thismonth_new_operator' => $thismonth_new_operator,
            'lastmonth_new_operator' => $lastmonth_new_operator,
            'total_new_operator' => $total_new_operator,


            'todayoperator_request_quote' => $todayoperator_request_quote,
            'thisweek_operator_request_quote' => $thisweek_operator_request_quote,
            'thismonth_operator_request_quote' => $thismonth_operator_request_quote,
            'lastmonth_operator_request_quote' => $lastmonth_operator_request_quote,
            'total_operator_request_quote' => $total_operator_request_quote,

            'todaynew_package' => $todaynew_package,
            'thisweek_new_package' => $thisweek_new_package,
            'thismonth_new_package' => $thismonth_new_package,
            'lastmonth_new_package' => $lastmonth_new_package,
            'total_new_package' => $total_new_package,



            'todaypackage_request_quote' => $todaypackage_request_quote,
            'thisweek_package_request_quote' => $thisweek_package_request_quote,
            'thismonth_package_request_quote' => $thismonth_package_request_quote,
            'lastmonth_package_request_quote' => $lastmonth_package_request_quote,
            'total_package_request_quote' => $total_package_request_quote,


            'todaynew_share_safari' => $todaynew_share_safari,
            'thisweek_new_share_safari' => $thisweek_new_share_safari,
            'thismonth_new_share_safari' => $thismonth_new_share_safari,
            'lastmonth_new_share_safari' => $lastmonth_new_share_safari,
            'total_new_share_safari' => $total_new_share_safari,


            'todaynew_fixed_departure' => $todaynew_fixed_departure,
            'thisweek_new_fixed_departure' => $thisweek_new_fixed_departure,
            'thismonth_new_fixed_departure' => $thismonth_new_fixed_departure,
            'lastmonth_new_fixed_departure' => $lastmonth_new_fixed_departure,
            'total_new_fixed_departure' => $total_new_fixed_departure,

            'todaynew_blog' => $todaynew_blog,
            'thisweek_new_blog' => $thisweek_new_blog,
            'thismonth_new_blog' => $thismonth_new_blog,
            'lastmonth_new_blog' => $lastmonth_new_blog,
            'total_new_blog' => $total_new_blog,
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
            Yii::$app->db->createCommand()
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
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
       
        $request = Yii::$app->request;
        $user_session_id = Yii::$app->user->id;
        $error_type = $exception->statusCode;
        $error_msg = $exception->getMessage();
        $pathInfo = $request->pathInfo;
        $source = $request->userAgent;
        $request_url = $request->absoluteUrl;
        $reference_url = $request->referrer;
        $method = $request->getMethod();
        $ip_address = $request->getRemoteIP();
        $error_model = new BackendErrorLogForm();
        $error_model->scenario = 'create';
        $error_model->backend_errorlog->setAttributes([
            'error_type'            => $error_type,
            'request_url'           => $request_url,
            'reference_url'         => $reference_url,
            'ip_address'            => $ip_address,
            'request_type'          => $method,
            'error_msg'             => $error_msg,
            'user_session_id'       => $user_session_id,
            'source'                => $source,
            'user_agent'            => Yii::$app->request->userAgent,
        ]);
        $error_model->backend_errorlog->save(false);

        return $this->render(
            'error',
            [
                'name' => $exception->getMessage() . '(#' . $exception->statusCode . ')',
                'message' => $exception->getMessage(),
                'exception' => $exception
            ]
        );
    }
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
}
