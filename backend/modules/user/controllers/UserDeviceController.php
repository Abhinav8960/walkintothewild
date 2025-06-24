<?php

namespace backend\modules\user\controllers;

use Yii;
use common\models\User;
use yii\web\Controller;
use common\models\UserSearch;
use common\models\UserSession;
use yii\data\ActiveDataProvider;

/**
 * UserDeviceController for the `user` module
 */
class UserDeviceController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }


    public function actionUserDevice($user_id)
    {
        $query = UserSession::find()
            ->where(['user_id' => $user_id])
            ->andWhere(['not', ['firebase_token' => null]]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        return $this->renderAjax('user_devices', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionUserList($q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $users = User::find()
            ->select(['id', 'name', 'email'])
            ->where(['status' => User::STATUS_ACTIVE])
            ->andFilterWhere([
                'or',
                ['like', 'name', $q],
                ['like', 'mobile_no', $q],
                ['like', 'username', $q],
                ['like', 'email', $q]
            ])
            ->limit(20)
            ->asArray()
            ->all();

        $results = [];

        foreach ($users as $user) {
            $results[] = [
                'id' => $user['id'],
                'text' => $user['name'] . ' (' . $user['email'] . ')', // Show name with email in brackets
            ];
        }

        return ['results' => $results];
    }

    /**
     * Find User By Id
     *
     * @param [type] $id
     * @return User
     */
    protected function findModel($id)
    {
        $user = User::find()->where(['id' => $id])->one();

        if ($user === null) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist');
        }
        return $user;
    }
}
