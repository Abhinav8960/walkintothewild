<?php

namespace backend\modules\sharesafari\controllers;


use common\interfaces\StatusInterface;
use common\models\sharesafari\form\ShareSafariApprovalForm;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariComment;
use common\models\sharesafari\ShareSafariCommentReport;
use common\models\sharesafari\ShareSafariSearch;
use Yii;
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
        $searchModel = new ShareSafariSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $share_safari = ShareSafari::find()
            ->where([
                'id' => $id,
            ])->limit(1)->one();
        return $this->render('view', [
            'share_safari' => $share_safari,
        ]);
    }



    public function actionFlag($slug, $park_id, $share_safari_comment_id)
    {
        $share_safari = ShareSafari::find()->where(['slug' => $slug])->one();
        if (!$share_safari) {
            return $this->redirect(['/sharesafari/default/index']);
        }



        $query = ShareSafariCommentReport::find()
            ->where([
                'share_safari_id' => $share_safari->id,
                'share_safari_comment_id' => $share_safari_comment_id,
                'park_id' => $park_id,
            ]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_flag_list', [
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionApproved($id)
    {
        $share_safari_model = $this->findModel($id);
        $model = new ShareSafariApprovalForm($share_safari_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->share_safari_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['view', 'id' => $id]);
                    }
                }
            }
        } else {
            $model->share_safari_model->loadDefaultValues();
        }
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    public function findModel($id)
    {
        if ($model = ShareSafari::find()->limit(1)->one()) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
