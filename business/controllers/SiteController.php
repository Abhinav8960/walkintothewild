<?php

namespace business\controllers;

use api\models\operator\SafariOperator as OperatorSafariOperator;
use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use business\components\AuthHandler;
use common\models\CustomLoginForm;
use common\models\leads\Lead;
use common\models\MailLog;
use common\models\operator\OperatorQuote;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorPark;
use common\models\package\Package;
use common\models\park\SafariPark;
use common\models\registration\SafariOperatorRequest;
use common\models\RestrictedFiles;
use common\models\sighting\Sighting;
use common\models\User;
use common\models\UserPosts;
use Google\Service\Blogger\Resource\Posts;
use yii\db\Expression;
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
                        'actions' => ['login', 'error', 'auth', 'files','custom-login'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'auth', 'files'],
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
        if (!SafariOperator::find()->where(['user_id' => \Yii::$app->user->id])->limit(1)->exists()) {
            return $this->redirect(['/partner-registration/create']);
        }
        if (!SafariOperator::find()->where(['user_id' => \Yii::$app->user->id, 'status' => SafariOperator::STATUS_ACTIVE])->limit(1)->exists()) {
            return $this->redirect(['/partner-registration/deactivate']);
        }

        $safarioperator = SafariOperator::find()->where(['user_id'=>Yii::$app->user->identity->id,'status'=>SafariOperator::STATUS_ACTIVE])->one();
        $leads = Lead::find()->where(['operator_id'=>$safarioperator->id,'status'=>Lead::STATUS_ACTIVE])->count();
        $posts = UserPosts::find()->where(['safari_operator_id'=>$safarioperator->id,'status'=>UserPosts::STATUS_ACTIVE])->orderBy(['id'=>SORT_DESC])->limit(2)->all();
        $sightings = Sighting::find()->where(['safari_operator_id'=>$safarioperator->id,'status'=>Sighting::STATUS_ACTIVE])->orderBy(['id'=>SORT_DESC])->limit(3)->all();
        $packages = Package::find()->where(['owned_by_id'=>$safarioperator->id,'status'=>Package::STATUS_ACTIVE])->orderBy(['id'=>SORT_DESC])->limit(2)->all();

        $parks_count = SafariOperatorPark::find()->select(['park_id', 'count' => new Expression('COUNT(*)')])->where(['safari_operator_id'=>$safarioperator->id,'status'=>SafariOperatorPark::STATUS_ACTIVE])->groupBy('park_id')->orderBy(['count' => SORT_DESC])->limit(2)->asArray()->all();
        $park_ids = array_column($parks_count, 'park_id');
        $demanding_parks = SafariPark::find()->where(['id' =>$park_ids])->andWhere(['status' =>SafariPark::STATUS_ACTIVE])->all();
       
        $operator_quotes = OperatorQuote::find()->select(['id', 'quote_count' => new Expression('COUNT(*)')])->where(['id' => $park_ids, 'status' => OperatorQuote::STATUS_ACTIVE])->groupBy('id')->asArray()->all();
        
        return $this->render('index',[
            'leads'=>$leads,
            'posts'=>$posts,
            'sightings'=>$sightings,
            'packages'=>$packages,
            'demanding_parks'=>$demanding_parks,
            'operator_quotes'=>$operator_quotes,
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
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('signin', [
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

    // public function actionCustomLogin()
    // {
    //     if (!Yii::$app->user->isGuest) {
    //         return $this->goHome();
    //     }

    //     $this->layout = 'blank';

    //     $model = new CustomLoginForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->login()) {
    //         return $this->goBack();
    //     }

    //     return $this->render('custom_login', [
    //         'model' => $model,
    //     ]);
    // }


    // public function actionFiledownload($filepath, $original_name = NULL, $duration = 1)
    // {
    //     $expiresAt = new \DateTimeImmutable("+$duration minutes");
    //     $url = Yii::$app->rfs->temporaryUrl($filepath, $expiresAt);

    //     if (!$url) {
    //         throw new \yii\web\BadRequestHttpException("Temporary URL could not be generated.");
    //     }

    //     $fileContent = @file_get_contents($url);
    //     if ($fileContent === false) {
    //         throw new \yii\web\NotFoundHttpException("Unable to fetch the file content.");
    //     }

    //     $filename = basename($filepath);
    //     if (!empty($original_name)) {
    //         $filename = $original_name;
    //     }

    //     return Yii::$app->response->sendContentAsFile($fileContent, $filename);
    // }


    // public function actionFileshow($filepath, $duration = 1)
    // {
    //     $expiresAt = new \DateTimeImmutable("+$duration minutes");
    //     $url = Yii::$app->rfs->temporaryUrl($filepath, $expiresAt);

    //     if (!$url) {
    //         throw new \yii\web\BadRequestHttpException("Temporary URL could not be generated.");
    //     }

    //     $imginfo = getimagesize($url);
    //     header("Content-type: {$imginfo['mime']}");
    //     readfile($url);
    // }


    public function actionFiles($filepath, $duration = 1)
    {
        $expiresAt = new \DateTimeImmutable("+$duration minutes");
        $url = Yii::$app->rfs->temporaryUrl($filepath, $expiresAt);

        if (!$url) {
            throw new \yii\web\BadRequestHttpException("Temporary URL could not be generated.");
        }


        $fileContents = @file_get_contents($url);

        if ($fileContents === false) {
            throw new \yii\web\BadRequestHttpException("Failed to retrieve file content.");
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($fileContents);

        if (!$mimeType) {
            throw new \yii\web\BadRequestHttpException("Could not determine MIME type of the file.");
        }

        $filename = basename($filepath);

        $original_file_name = RestrictedFiles::find()->where(['file_path' => $filepath])->orderBy(['created_at' => SORT_DESC])->limit(1)->one();
        if (!empty($original_file_name)) {
            $filename = $original_file_name->original_name;
        }

        header("Content-Type: $mimeType");


        if (strpos($mimeType, 'image/') === 0) {
            header("Content-Disposition: inline; filename=\"" . $filename . "\"");
        } else {
            header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
        }

        echo $fileContents;
    }
}
