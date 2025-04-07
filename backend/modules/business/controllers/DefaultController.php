<?php

namespace backend\modules\business\controllers;

use common\models\business\Business;
use common\models\business\businessrequest\BusinessRequest;
use common\models\business\businessrequest\BusinessRequestSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new BusinessRequestSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionApproved($id)
    {
        $model = $this->findModel($id);
        if ($model->is_approved == 0) {
            $model->is_approved = 1;
            if ($model->save(false)) {
                $business_model = new Business();
                $business_model->business_request_id = $model->id;
                $business_model->business_name = $model->business_name;
                $business_model->slug = $model->slug;
                $business_model->about_business = $model->about_business;
                $business_model->address = $model->address;
                $business_model->phone_no = $model->phone_no;
                $business_model->email = $model->email;
                $business_model->alternate_phone_no = $model->alternate_phone_no;
                $business_model->alternate_email = $model->alternate_email;
                $business_model->status = $model->status;
                $business_model->save(false);
                \Yii::$app->getSession()->setFlash('success', 'Approved Successfully');
            }
        } else {
            $model->is_approved = 0;
            $model->save(false);
            \Yii::$app->getSession()->setFlash('success', 'Disapproved Successfully');
        }

        return $this->redirect(['index']);
    }



    protected function findModel($id)
    {
        if (($model = BusinessRequest::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
