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
use common\models\sharesafari\ShareSafariFaqSearch;
use common\models\sharesafari\ShareSafariIntrested;
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

        if ((Yii::$app->user->identity && Yii::$app->user->identity->is_safari_operator) && !(Yii::$app->user->identity->is_admin || Yii::$app->user->identity->is_adminstrator)) {
            $searchModel->host_user_id = Yii::$app->user->identity->id;
        }
        // $searchModel->report_days = 'today';
        // $searchModel->status = 1;
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
        // $searchModel->report_days = 'today';
        // $searchModel->status = 1;
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);
        $faqs = $dataProvider->getModels();

        return $this->render('_fixed_view', [
            'share_safari' => $share_safari,
            'faqs' => $faqs,
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
}
