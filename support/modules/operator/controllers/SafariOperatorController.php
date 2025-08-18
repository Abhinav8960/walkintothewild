<?php

namespace support\modules\operator\controllers;

use common\interfaces\NewStatusInterface;
use common\models\Auth;
use Yii;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\MailLog;
use common\models\operator\form\SafariOperatorDeleteForm;
use common\models\operator\form\SafariOperatorForm;
use common\models\operator\form\SafariOperatorLogoForm;
use common\models\operator\form\SafariOperatorParkForm;
use common\models\operator\form\SafariOperatorRequestForm;
use common\models\operator\OperatorQuoteSearch;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorActivities;
use common\models\operator\SafariOperatorFollowSearch;
use common\models\operator\SafariOperatorPark;
use common\models\operator\SafariOperatorRatingReportSearch;
use common\models\operator\SafariOperatorRatingSearch;
use common\models\operator\SafariOperatorSearch;
use common\models\registration\SafariOperatorRequest;
use common\models\registration\SafariOperatorRequestActivities;
use common\models\registration\SafariOperatorRequestPark;
use common\models\SafariOperatorRequestSearch;
use common\models\User;
use common\models\UserFollow;
use yii\data\ActiveDataProvider;

/**
 * SafariOperatorController.
 */
class SafariOperatorController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SafariOperatorSearch();
        // $searchModel->report_days = 'today';
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Overview Operator
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', ['model' => $model]);
    }

    /**
     * View Partner Legal Entity Details
     */

    public function actionLegalEntity($id)
    {
        $model = $this->findModel($id);

        return $this->render('legal_entity', ['model' => $model]);
    }

    /**
     * View Partner Registration Details
     */
    public function actionRegistrationProof($id)
    {
        $model = $this->findModel($id);

        return $this->render('registration_proof', ['model' => $model]);
    }

    /**
     * View Partner Business Details
     */
    public function actionBusiness($id)
    {
        $model = $this->findModel($id);

        return $this->render('business', ['model' => $model]);
    }

    /**
     * View Partner Bank Details
     */    
    public function actionBankDetails($id)
    {
        $model = $this->findModel($id);

        return $this->render('bank_details', ['model' => $model]);
    }

    /**
     * View Partner User Kyc Details
     */    
    public function actionUserKyc($id)
    {
        $model = $this->findModel($id);

        return $this->render('userkyc_details', ['model' => $model]);
    }

    /**
     * View Partner User Review Details
     */    
    public function actionUserReview($id)
    {
        $model = $this->findModel($id);
        $searchModel = new SafariOperatorRatingSearch();
        $searchModel->safari_operator_id = $id;
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('user_review', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * View Partner Operator Parks Details
     */   
    public function actionOperatorParks($id)
    {
        $operator_model = $this->findModel($id);

        $query =  SafariOperatorPark::find()->where(['status' => SafariOperatorPark::STATUS_ACTIVE, 'safari_operator_id' => $operator_model->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('operator_parks', ['dataProvider' => $dataProvider, 'operator_model' => $operator_model]);
    }


    /**
     * View Operator
     */
    public function actionSharedsafari($id)
    {
        $model = $this->findModel($id);
        return $this->render('shared_safari', ['model' => $model]);
    }


    /**
     * View Operator
     */
    public function actionFlagview($id, $safari_operator_id)
    {

        $searchModel = new SafariOperatorRatingReportSearch();
        $searchModel->safari_operator_rating_id = $id;
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);

        $model = $this->findModel($safari_operator_id);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('flag_review', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
            ]);
        }
    }
    /**
     * View Operator
     */
    public function actionFollower($id)
    {
        $operator = SafariOperator::find()->where(['id' => $id])->limit(1)->one();
        $follow_query = $operator->getFollowerlist()->joinWith('user')->where(['user_follower.status' => 1, 'user.status' => User::STATUS_ACTIVE]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $follow_query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $model = $this->findModel($id);
        return $this->render('follower', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Suspend Model
     *
     * @param [type] $id
     * @return void
     */
    public function actionSuspend($id)
    {
        $model = $this->findModel($id);
        $model->status = SafariOperator::STATUS_SUSPEND;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionActive($id)
    {
        $model = $this->findModel($id);
        $model->status = SafariOperator::STATUS_ACTIVE;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }


    protected function findModel($id)
    {
        if (($model = SafariOperator::findOne(['id' => $id, 'status' => [SafariOperator::STATUS_ACTIVE, SafariOperator::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

   

    public function actionValidate($id)
    {
        $safari_operator = $this->findModel($id);
        $model = new SafariOperatorRequestForm($safari_operator);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    public function actionDelete($id)
    {
        $safari_operator_delete_model = $this->findModel($id);
        $model = new SafariOperatorDeleteForm($safari_operator_delete_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safari_operator_delete_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Successfully Deleted');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->safari_operator_delete_model->loadDefaultValues();
        }
        return $this->renderAjax('_delete_form', [
            'model' => $model,
            'safari_operator_model' => $safari_operator_delete_model,
        ]);
    }

    public function actionTemporaryDelete($id)
    {
        $safari_operator = $this->findModel($id);
        if ($safari_operator) {
            $user_model = User::find()->where(['id' => $safari_operator->user_id])->limit(1)->one();
            // $auth_model = Auth::find()->where(['user_id' => $user_model->id])->limit(1)->all();

            $user_model->status = User::STATUS_DELETED;
            $safari_operator->status =  SafariOperator::STATUS_DELETE;

            $safari_operator->is_temporary_delete = 1;
            $safari_operator->email = time() . '_' . $safari_operator->email;
            $safari_operator->operator_email = time() . '_' . $safari_operator->operator_email;

            if ($safari_operator->save(false)) {

                $user_model->username = time() . '_' . $user_model->username;
                $user_model->email = time() . '_' . $user_model->email;
                if ($user_model->google_source_id != null) {
                    $user_model->google_source_id = time() . '_' . $user_model->google_source_id;
                }
                if ($user_model->apple_source_id != null) {
                    $user_model->apple_source_id = time() . '_' . $user_model->apple_source_id;
                }

                if ($user_model->save(false)) {

                    // foreach ($auth_model as $auth) {
                    //     $auth->source_id = time() . '_' . $auth->source_id;
                    //     $auth->save(false);
                    // }
                    \Yii::$app->session->setFlash('success', 'Successfully Temporary Deleted');
                    return $this->redirect(['index']);
                }
            }
        }
    }


    public function actionRemovePark($id, $park_id)
    {
        $operator_model = $this->findModel($id);

        $operator_park =  SafariOperatorPark::find()->where(['id' => $park_id, 'status' => SafariOperatorPark::STATUS_ACTIVE])->limit(1)->one();
        if ($operator_park) {
            $operator_park->status = SafariOperatorPark::STATUS_SUSPEND;
            if ($operator_park->save(false)) {
                \Yii::$app->session->setFlash('success', 'Successfully Removed');
                return $this->redirect(['operator-parks', 'id' => $operator_model->id]);
            }
        }
    }


    public function actionAddPark($id)
    {
        $operator_model = $this->findModel($id);

        $model = new SafariOperatorParkForm();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    if ($model->parks) {
                        foreach ($model->parks as $park) {
                            $park_model = new SafariOperatorPark();
                            $park_model->safari_operator_id = $id;
                            $park_model->park_id = $park;
                            $park_model->status = SafariOperatorPark::STATUS_ACTIVE;
                            $park_model->save(false);
                        }
                    }
                    \Yii::$app->session->setFlash('success', 'Successfully Deleted');
                    return $this->redirect(['operator-parks', 'id' => $id]);
                }
            }
        } else {
            $model->safari_operator_park_model->loadDefaultValues();
        }

        return $this->renderAjax('_add_park_form', [
            'operator_model' => $operator_model,
            'model' => $model,
        ]);
    }

    public function actionFileView($filepath, $duration = 1)
    {
        $urlParts = parse_url($filepath);
        $relativePath = ltrim($urlParts['path'], '/');

        if (strpos($relativePath, 'site/files/') === 0) {
            $relativePath = substr($relativePath, strlen('site/files/'));
        }

        $expiresAt = new \DateTimeImmutable("+$duration minutes");
        $url = Yii::$app->rfs->temporaryUrl($relativePath, $expiresAt);
        return $this->renderAjax('_file_view', ['fileUrl' => $url]);
    }
}
