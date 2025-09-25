<?php

namespace accounts\controllers;

use accounts\components\AuthHandler;
use common\models\LoginForm;
use common\models\transaction\Transaction;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
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
                        'actions' => ['login', 'error', 'auth'],
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
        $today_success_transaction = Transaction::find()->where(['status' => Transaction::STATUS_SUCCESS])->andWhere(['between', 'created_at', strtotime('today'), strtotime('tomorrow') - 1])->count();
        $last_three_day_success_transaction = Transaction::find()->where(['status' => Transaction::STATUS_SUCCESS])->andWhere(['between', 'created_at', strtotime('-3 days'), time()])->count();
        $last_seven_day_success_transaction = Transaction::find()->where(['status' => Transaction::STATUS_SUCCESS])->andWhere(['between', 'created_at', strtotime('-7 days'), time()])->count();

        return $this->render('index', [
            'today_success_transaction' => $today_success_transaction,
            'last_three_day_success_transaction' => $last_three_day_success_transaction,
            'last_seven_day_success_transaction' => $last_seven_day_success_transaction,
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
}
