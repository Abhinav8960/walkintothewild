<?php

namespace backend\modules\sharesafari\controllers;


use common\interfaces\StatusInterface;
use common\models\sharesafari\form\ShareSafariApprovalForm;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariComment;
use common\models\sharesafari\ShareSafariCommentReport;
use common\models\sharesafari\ShareSafariRequest;
use common\models\sharesafari\ShareSafariSearch;
use frontend\models\form\SharedSafariRequestForm;
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

        if (Yii::$app->user->identity && Yii::$app->user->identity->is_safari_operator) {
            $searchModel->host_user_id = Yii::$app->user->identity->id;
        }
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



    public function actionOrganizeSafari($id)
    {
        $shared_safari_model = ShareSafari::find()->where(['id' => $id])->limit(1)->one();
        $model = new SharedSafariRequestForm($shared_safari_model);
        $model->share_safari_id = $id;
        $model->status = ShareSafariRequest::STATUS_ACTIVE;
        $model->action_url = '/sharesafari/default/organize-safari?id=' . $id . '';
        $model->action_validate_url = '/sharesafari/default/validate?id=' . $id;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->shared_safari_image = \yii\web\UploadedFile::getInstance($model, 'shared_safari_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_request_model->save(false)) {
                        $model->UploadFiles($model->shared_safari_request_model->id);

                        \Yii::$app->session->setFlash('success', 'Shared Safari Created Successfully');
                        return $this->redirect(['index']);
                    }
                } else {
                    print_r($model->errors);
                    exit;
                }
            }
        } else {
            $model->shared_safari_request_model->loadDefaultValues();
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('organize_form', [
                'model' => $model,
            ]);
        } else {
            return $this->render('organize_form', [
                'model' => $model,
            ]);
        }
    }


    public function actionValidate($id = null)
    {

        if ($id != null) {
            $shared_safari_request_model = ShareSafari::find()->where(['id' => $id])->limit(1)->one();
            $model = new SharedSafariRequestForm($shared_safari_request_model);
        } else {

            $model = new SharedSafariRequestForm();
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    public function actionDisapprove($id)
    {
        $model = ShareSafariComment::find()->where(['id' => $id])->limit(1)->one();
        $model->status = StatusInterface::STATUS_SUSPEND;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Comment disapprove Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionApprove($id)
    {
        $model = ShareSafariComment::find()->where(['id' => $id])->limit(1)->one();
        $model->status = StatusInterface::STATUS_ACTIVE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Comment approved Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function findModel($id)
    {
        if ($model = ShareSafari::find()->limit(1)->one()) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
