<?php

namespace api\modules\profile\controllers;

use Yii;

use api\behaviours\Verbcheck;
use yii\filters\AccessControl;
use api\behaviours\Apiauth;
use api\controllers\RestController;
use api\models\User;
use yii\web\ForbiddenHttpException;

/**
 * Default controller
 */
class DefaultController extends RestController
{


    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
            'apiauth' => [
                'class' => Apiauth::className(),
                'exclude' => ['index'],
            ],
            // 'access' => [
            //     'class' => AccessControl::className(),
            //     'only' => [],
            //     'rules' => [
            //         [
            //             'actions' => [],
            //             'allow' => true,
            //             'roles' => ['@'],
            //         ],
            //     ],
            // ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'index' => ['GET'],

                ],
            ],
        ];
    }


    public function actionIndex($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        if ($user->operator) {
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Sent to Operator Profile"]);
        }

        return Yii::$app->api->sendResponse($data = [$user]);
    }

    public function findUserbyHandle($user_handle)
    {
        if ($user = User::find()->where(['user_handle' => $user_handle])->andWhere(['blocked_at' => null, 'status' => User::STATUS_ACTIVE])->limit(1)->one()) {
            return $user;
        }

        throw new ForbiddenHttpException('User Not Found / User Account may be Blocked');
    }
}
