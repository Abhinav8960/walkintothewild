<?php

namespace backend\modules\sharesafari\controllers;


use common\interfaces\StatusInterface;
use common\models\MailLog;
use common\models\operator\SafariOperator;
use common\models\park\SafariPark;
use common\models\sharesafari\form\ShareSafariApprovalForm;
use common\models\sharesafari\form\ShareSafariDeleteForm;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariComment;
use common\models\sharesafari\ShareSafariCommentReport;
use common\models\sharesafari\ShareSafariCommentSearch;
use common\models\sharesafari\ShareSafariFaqSearch;
use common\models\sharesafari\ShareSafariIntrested;
use common\models\sharesafari\ShareSafariRequest;
use common\models\sharesafari\ShareSafariSearch;
use common\models\User;
use frontend\models\form\SharedSafariRequestForm;
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

        if ((Yii::$app->user->identity && Yii::$app->user->identity->is_safari_operator) && !(Yii::$app->user->identity->is_admin || Yii::$app->user->identity->is_adminstrator)) {
            $searchModel->host_user_id = Yii::$app->user->identity->id;
        }
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

        if ((Yii::$app->user->identity && Yii::$app->user->identity->is_safari_operator) && !(Yii::$app->user->identity->is_admin || Yii::$app->user->identity->is_adminstrator)) {
            $searchModel->host_user_id = Yii::$app->user->identity->id;
        }

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
            \Yii::$app->session->setFlash('error', 'Invalid request');
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
            \Yii::$app->session->setFlash('error', 'Invalid request');
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


    public function actionOrganizeSafariNew()
    {
        if (Yii::$app->user->identity) {
            if (Yii::$app->user->identity->is_safari_operator == 1) {
                $model = new SharedSafariRequestForm();
                $model->host_user_id = Yii::$app->user->identity->id;
                $model->status = ShareSafariRequest::STATUS_ACTIVE;
                $model->action_url = '/sharesafari/default/organize-safari-new';
                $model->action_validate_url = '/sharesafari/default/validate';
                if ($this->request->isPost) {
                    if ($model->load($this->request->post())) {
                        $model->shared_safari_image = \yii\web\UploadedFile::getInstance($model, 'shared_safari_image');
                        if ($model->validate()) {
                            $model->initializeForm();
                            if ($model->shared_safari_request_model->save(false)) {
                                $model->UploadFiles($model->shared_safari_request_model->id);
                                if ($model->shared_safari_request_model->user) {
                                    $user = $model->shared_safari_request_model->user;
                                    $to_mail = $user->email;
                                    $subject = 'New Safari Request';
                                    $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_SAFARI_OPERATOR_FREE_QUOTE;
                                    $req = ['username' => $user->name];
                                    MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                                }

                                \Yii::$app->session->setFlash('success', 'Shared Safari Created Successfully');
                                return $this->redirect(['index']);
                            }
                        } else {
                            print_r($model->errors);
                            die();
                        }
                    }
                } else {
                    $model->shared_safari_request_model->loadDefaultValues();
                }
                if (Yii::$app->request->isAjax) {
                    return $this->renderAjax('organize_form_new', [
                        'model' => $model,
                    ]);
                } else {
                    return $this->render('organize_form_new', [
                        'model' => $model,
                    ]);
                }
            } else {
                throw new \yii\web\ForbiddenHttpException('You are not authorized to perform this action. Only Operator can View this page.');
            }
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

    public function actionFixedView($id)
    {
        $share_safari = ShareSafari::find()->where(['id' => $id])->limit(1)->one();
        $searchModel = new ShareSafariFaqSearch();
        $searchModel->share_safari_id = $share_safari->id;
        $searchModel->version = $share_safari->live_version;
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
                        \Yii::$app->session->setFlash('success', 'Successfully Deleted');
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
                        \Yii::$app->session->setFlash('success', 'Successfully Deleted');
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
            \Yii::$app->session->setFlash('success', 'Api Publish change Successfully');
        } else {
            \Yii::$app->session->setFlash('error', 'Facing technical problem Successfully');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionPublishOnWeb($id)
    {
        $model = ShareSafari::find()->where(['id' => $id])->limit(1)->one();
        if ($model) {
            $model->is_published_on_web = !$model->is_published_on_web;
            $model->save(false);
            \Yii::$app->session->setFlash('success', 'Web Publish change Successfully');
        } else {
            \Yii::$app->session->setFlash('error', 'Facing technical problem Successfully');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionShareSafariActive($id)
    {
        $share_safari = ShareSafari::find()->where(['id' => $id])->limit(1)->one();

        if ($share_safari) {
            $share_safari->status = ShareSafari::STATUS_ACTIVE;
            if ($share_safari->save(false)) {
                \Yii::$app->session->setFlash('success', 'Active Successfully!!!');
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        \Yii::$app->session->setFlash('danger', 'Not Found!!!');
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
