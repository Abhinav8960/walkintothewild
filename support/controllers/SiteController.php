<?php

namespace support\controllers;

use api\models\operator\SafariOperator as OperatorSafariOperator;
use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use support\components\AuthHandler;
use common\models\leads\Lead;
use common\models\operator\OperatorQuote;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorPark;
use common\models\operator\SafariOperatorRating;
use common\models\package\Package;
use common\models\package\PackageComment;
use common\models\package\PackageVersion;
use common\models\park\SafariPark;
use common\models\park\SafariParkRating;
use common\models\partnergallery\PartnerGallery;
use common\models\postscomment\UserPostComment;
use common\models\RestrictedFiles;
use common\models\sharesafari\ShareSafariComment;
use common\models\sharesafari\ShareSafariVersion;
use common\models\sighting\Sighting;
use common\models\sighting\SightingComment;
use common\models\UserPosts;
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
                        'actions' => ['login', 'error', 'auth', 'files', 'custom-login'],
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

        $package_model = PackageVersion::find()->where(['status' => PackageVersion::SEND_FOR_APPROVAL_STATUS])->count();
        $fixed_departure_model = ShareSafariVersion::find()->where(['status' => ShareSafariVersion::SEND_FOR_APPROVAL_STATUS])->count();
        $operator_review_model = SafariOperatorRating::find()->where(['status' => SafariOperatorRating::STATUS_CREATE])->count();
        $park_review_model = SafariParkRating::find()->where(['status' => SafariParkRating::STATUS_SUSPEND])->count();
        $gallery_model = PartnerGallery::find()->where(['IN', 'listing_status', [10, 1]])->andWhere(['edit_status' => 2])->count();
        $post_model = UserPostComment::find()->where(['flaged' => 1, 'deleted_by' => 0])->count();
        $sighting_model = SightingComment::find()->where(['flaged' => 1, 'deleted_by' => 0])->count();
        $share_safari_flag_model = ShareSafariComment::find()->where(['flaged' => 1, 'deleted_by' => 0])->count();
        $package_flag_model = PackageComment::find()->where(['flaged' => 1])->andWhere(['deleted_by' => 0])->count();
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
