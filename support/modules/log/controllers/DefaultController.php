<?php

namespace support\modules\log\controllers;

use common\models\MailLog;
use common\models\MailLogSearch;
use common\models\master\email\MasterMailTemplate;
use common\models\sharesafari\ShareSafari;
use common\models\transaction\TransactionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DefaultController.
 */
class DefaultController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MailLogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $master_mail_template = MasterMailTemplate::find()->where(['id' => $model->mail_template_id, 'status' => MasterMailTemplate::STATUS_ACTIVE])->one();
        return $this->render('view', [
            'master_mail_template' => $master_mail_template,
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = MailLog::findOne(['id' => $id, 'status' => [MailLog::STATUS_ACTIVE, MailLog::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionTransaction()
    {

        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('transaction', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
