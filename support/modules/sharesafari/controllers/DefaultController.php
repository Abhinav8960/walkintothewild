<?php

namespace support\modules\sharesafari\controllers;


use common\interfaces\StatusInterface;
use common\models\park\SafariPark;
use common\models\sharesafari\form\ShareSafariDeleteForm;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariComment;
use common\models\sharesafari\ShareSafariCommentReport;
use common\models\sharesafari\ShareSafariCommentSearch;
use common\models\sharesafari\ShareSafariFaqSearch;
use common\models\sharesafari\ShareSafariIntrested;
use common\models\sharesafari\ShareSafariSearch;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
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
        $searchModel->report_days = 'all';
        $searchModel->custom_status = 3;
        $dataProvider = $searchModel->sharedsafarisearch(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionFixedDeparture()
    {
        $searchModel = new ShareSafariSearch();
        $searchModel->report_days = 'all';
        $searchModel->status = 1;
        $dataProvider = $searchModel->fixeddeparturesearch(Yii::$app->request->queryParams);

        return $this->render('fixed_departure_index', [
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

        $searchModel = new ShareSafariCommentSearch();
        $searchModel->share_safari_id = $share_safari->id;
        $dataProvider = $searchModel->listingsearch($this->request->queryParams);
        $dataProvider->query->andWhere(['parent_id' => null]);


        return $this->render('view', [
            'share_safari' => $share_safari,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionReplyview($id)
    {
        $review = ShareSafariComment::find()->where(['parent_id' => $id]);
        if (empty($review)) {
            $message = Yii::$app->messageManager->getMessage('common.invalid_request');
            \Yii::$app->session->setFlash('error', $message);
            return $this->redirect(['index']);
        }
        $dataProvider = new ActiveDataProvider([
            'query' =>  $review,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->renderAjax('_replyview', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFlagview($id)
    {
        $review = ShareSafariCommentReport::find()->where(['share_safari_comment_id' => $id]);
        if (empty($review)) {
            $message = Yii::$app->messageManager->getMessage('common.invalid_request');
            \Yii::$app->session->setFlash('error', $message);
            return $this->redirect(['index']);
        }
        $dataProvider = new ActiveDataProvider([
            'query' =>  $review,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->renderAjax('_flagview', [
            'dataProvider' => $dataProvider,
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


    // public function actionValidate($id = null)
    // {

    //     if ($id != null) {
    //         $shared_safari_request_model = ShareSafari::find()->where(['id' => $id])->limit(1)->one();
    //         $model = new SharedSafariRequestForm($shared_safari_request_model);
    //     } else {

    //         $model = new SharedSafariRequestForm();
    //     }
    //     if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
    //         Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    //         return \yii\widgets\ActiveForm::validate($model);
    //     }
    // }

    public function actionInterestview($share_safari_id)
    {
        $interest_model = ShareSafariIntrested::find()->where(['share_safari_id' => $share_safari_id, 'status' => StatusInterface::STATUS_ACTIVE])->all();
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('interest_view', [
                'interest_model' => $interest_model
            ]);
        }
    }

    public function actionGetparkimage($id)
    {
        $model = SafariPark::find()->where(['id' => $id])->limit(1)->one();
        $image = $model->featureimagepath;

        return $image;
    }

    public function actionDynamicsharedseat($total_seat)
    {
        echo "<option value=''>Select Shared Seat</option>";
        if ($total_seat == 2) {
            echo "<option value='1'>1</option>";
            echo "<option value='4'>2</option>";
        } elseif ($total_seat == 3) {
            echo "<option value='1'>1</option>";
            echo "<option value='2'>2</option>";
            echo "<option value='3'>3</option>";
        } elseif ($total_seat == 4) {
            echo "<option value='1'>1</option>";
            echo "<option value='2'>2</option>";
            echo "<option value='3'>3</option>";
            echo "<option value='4'>4</option>";
        } elseif ($total_seat == 5) {
            echo "<option value='1'>1</option>";
            echo "<option value='2'>2</option>";
            echo "<option value='3'>3</option>";
            echo "<option value='4'>4</option>";
            echo "<option value='5'>5</option>";
        } elseif ($total_seat == 6) {
            echo "<option value='1'>1</option>";
            echo "<option value='2'>2</option>";
            echo "<option value='3'>3</option>";
            echo "<option value='4'>4</option>";
            echo "<option value='5'>5</option>";
            echo "<option value='6'>6</option>";
        }
    }
    public function actionDisapprove($id)
    {
        $model = ShareSafariComment::find()->where(['id' => $id])->limit(1)->one();
        $model->status = StatusInterface::STATUS_SUSPEND;
        $model->save();
        $message = Yii::$app->messageManager->getMessage('common.rejected',['{var}' => 'Comment']);
        \Yii::$app->session->setFlash('success', $message);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionApprove($id)
    {
        $model = ShareSafariComment::find()->where(['id' => $id])->limit(1)->one();
        $model->status = StatusInterface::STATUS_ACTIVE;
        $model->save();
        $message = Yii::$app->messageManager->getMessage('common.approved_success',['{var}' => 'Comment']);
        \Yii::$app->session->setFlash('success', $message);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function findModel($id)
    {
        if ($model = ShareSafari::find()->limit(1)->one()) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionFixedView($id)
    {
        $share_safari = ShareSafari::find()->where(['id' => $id])->limit(1)->one();
        $searchModel = new ShareSafariFaqSearch();
        $searchModel->share_safari_id = $share_safari->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);
        $faqs = $dataProvider->getModels();

        $fixedsearchModel = new ShareSafariCommentSearch();
        $fixedsearchModel->share_safari_id = $share_safari->id;
        $fixedProvider = $fixedsearchModel->listingsearch($this->request->queryParams);
        $fixedProvider->query->andWhere(['parent_id' => null]);

        return $this->render('_fixed_view', [
            'share_safari' => $share_safari,
            'faqs' => $faqs,
            'fixedsearchModel' => $fixedsearchModel,
            'fixedProvider' => $fixedProvider,
        ]);
    }


    public function actionFixedDepartureDelete($id)
    {
        $share_safari_delete_model = ShareSafari::find()->where(['id' => $id])->limit(1)->one();
        $model = new ShareSafariDeleteForm($share_safari_delete_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->share_safari_delete_model->save(false)) {
                        $message = Yii::$app->messageManager->getMessage('common.deleted');
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['fixed-departure']);
                    }
                }
            }
        } else {
            $model->share_safari_delete_model->loadDefaultValues();
        }
        return $this->renderAjax('_delete_form', [
            'model' => $model,
        ]);
    }

    public function actionShareSafariDelete($id)
    {
        $share_safari_delete_model = ShareSafari::find()->where(['id' => $id])->limit(1)->one();
        $model = new ShareSafariDeleteForm($share_safari_delete_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->share_safari_delete_model->save(false)) {
                        $message = Yii::$app->messageManager->getMessage('common.deleted');
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->share_safari_delete_model->loadDefaultValues();
        }
        return $this->renderAjax('_delete_form', [
            'model' => $model,
        ]);
    }


    public function actionIntrested($id)
    {
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => ShareSafariIntrested::find()->where(['share_safari_id' => $id, 'status' => ShareSafariIntrested::STATUS_ACTIVE]),
            'pagination' => ['pageSize' => 50]
        ]);

        return $this->renderAjax(
            '_interested_view',
            [

                'interest_model' => $dataProvider->models,
                'dataProvider' => $dataProvider
            ]
        );
    }

    public function actionLeaved($id)
    {
        $interest_model = ShareSafariIntrested::find()->where(['share_safari_id' => $id, 'status' => 0])->all();
        return $this->renderAjax(
            '_interested_view',
            [
                'interest_model' => $interest_model,
            ]
        );
    }


    public function actionPinsafari($id)
    {
        $share_safari = ShareSafari::find()->where(['id' => $id])->limit(1)->one();
        if ($share_safari) {
            if ($share_safari->pined_safari == 1) {
                $share_safari->pined_safari = NULL;
            } else {
                $share_safari->pined_safari = 1;
            }
            $share_safari->save(false);
        }

        return $this->redirect('/sharesafari/default/index');
    }


    /**
     * Delete Comment of Safari
     */
    public function actionDeletecomment($id)
    {
        $model = ShareSafariComment::find()->where(['id' => $id])->limit(1)->one();
        if ($model) {
            $model->status = -1;
            $model->is_deleted = 1;
            $model->save(false);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionPublishOnApi($id)
    {
        $model = ShareSafari::find()->where(['id' => $id])->limit(1)->one();
        if ($model) {
            $model->is_published_on_api = !$model->is_published_on_api;
            $model->save(false);
            $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Api Publish change']);
            \Yii::$app->session->setFlash('success', $message);
        } else {
            $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Facing technical problem']);
            \Yii::$app->session->setFlash('error', $message);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionPublishOnWeb($id)
    {
        $model = ShareSafari::find()->where(['id' => $id])->limit(1)->one();
        if ($model) {
            $model->is_published_on_web = !$model->is_published_on_web;
            $model->save(false);
            $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Web Publish change']);
            \Yii::$app->session->setFlash('success', $message);
        } else {
            $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Facing technical problem']);
            \Yii::$app->session->setFlash('error', $message);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionShareSafariActive($id)
    {
        $share_safari = ShareSafari::find()->where(['id' => $id])->limit(1)->one();

        if ($share_safari) {
            $share_safari->status = ShareSafari::STATUS_ACTIVE;
            if ($share_safari->save(false)) {
                $message = Yii::$app->messageManager->getMessage('common.successfully' ,['{var}' => 'Active']);
                \Yii::$app->session->setFlash('success', $message);
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        $message = Yii::$app->messageManager->getMessage('common.not_found');
        \Yii::$app->session->setFlash('danger', $message);
        return $this->redirect(Yii::$app->request->referrer);
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
