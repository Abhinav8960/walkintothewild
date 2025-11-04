<?php

namespace backend\modules\userprivacypolicyacknowledgement\controllers;

use api\models\compliancedocuments\ComplianceDocuments as CompliancedocumentsApi;
use common\models\compliancedocuments\ComplianceDocuments;
use common\models\User;
use common\models\userprivacypolicyacknowledgement\UserPrivacyPolicyAcknowledgementSearch;
use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new UserPrivacyPolicyAcknowledgementSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
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
            ->orderBy(['name' => SORT_ASC])
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
}
