<?php

namespace backend\modules\sharesafari\controllers;


use common\interfaces\StatusInterface;
use common\models\MailLog;
use common\models\master\sharesafarireason\MasterShareSafariReason;
use common\models\sharesafari\form\ShareSafariApprovalForm;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariComment;
use common\models\sharesafari\ShareSafariCommentReport;
use common\models\sharesafari\ShareSafariRequest;
use common\models\sharesafari\ShareSafariRequestSearch;
use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Yii;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RequestController.
 */
class RequestController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ShareSafariRequestSearch();
        $searchModel->is_approved = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $share_safari_request = ShareSafariRequest::find()
            ->where([
                'id' => $id,
            ])->limit(1)->one();
        return $this->render('view', [
            'share_safari_request' => $share_safari_request,
        ]);
    }

    public function actionApproved($id)
    {
        $share_safari_request_approval_model = ShareSafariRequest::find()
            ->where([
                'id' => $id,
            ])->limit(1)->one();
        $model = new ShareSafariApprovalForm($share_safari_request_approval_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->share_safari_request_approval_model->save(false)) {
                        if ($model->is_approved == 1) {
                            $share_safari = ShareSafari::find()->where(['id' => $model->share_safari_request_approval_model->share_safari_id])->limit(1)->one();
                            if (!$share_safari) {
                                $share_safari = new ShareSafari();
                            }
                            $share_safari->slug                                  =  $model->share_safari_request_approval_model->slug;
                            $share_safari->share_safari_request_id               =  $model->share_safari_request_approval_model->id;
                            $share_safari->host_user_id                          =  $model->share_safari_request_approval_model->host_user_id;
                            $share_safari->host_type                             =  $model->share_safari_request_approval_model->host_type;
                            $share_safari->park_id                               =  $model->share_safari_request_approval_model->park_id;
                            $share_safari->share_safari_agenda_id                =  $model->share_safari_request_approval_model->share_safari_agenda_id;
                            $share_safari->image                                 =  $model->share_safari_request_approval_model->image;
                            $share_safari->no_of_safari                          =  $model->share_safari_request_approval_model->no_of_safari;
                            $share_safari->start_date                            =  $model->share_safari_request_approval_model->start_date;
                            $share_safari->end_date                              =  $model->share_safari_request_approval_model->end_date;
                            $share_safari->stay_category_id                      =  $model->share_safari_request_approval_model->stay_category_id;
                            $share_safari->estimate_price_min                    =  $model->share_safari_request_approval_model->estimate_price_min;
                            $share_safari->estimate_price_max                    =  $model->share_safari_request_approval_model->estimate_price_max;
                            $share_safari->safari_plan                           =  $model->share_safari_request_approval_model->safari_plan;
                            $share_safari->website_url                           =  $model->share_safari_request_approval_model->website_url;
                            $share_safari->total_seat                            =  $model->share_safari_request_approval_model->total_seat;
                            $share_safari->share_seat                            =  $model->share_safari_request_approval_model->share_seat;
                            $share_safari->status                                =  $model->share_safari_request_approval_model->status;
                            if ($share_safari->save(false)) {

                                // Function to recursively copy directories and their contents
                                function copyDirectory($source, $destination)
                                {
                                    if (!is_dir($source)) {
                                        echo "Source is not a valid directory: $source";
                                        return false;
                                    }

                                    if (!is_dir($destination)) {
                                        if (!mkdir($destination, 0777, true)) {
                                            echo "Failed to create directory: $destination";
                                            return false;
                                        }
                                    }

                                    $iterator = new RecursiveIteratorIterator(
                                        new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
                                        RecursiveIteratorIterator::SELF_FIRST
                                    );

                                    foreach ($iterator as $item) {
                                        $target = $destination . '/' . $iterator->getSubPathName();
                                        if ($item->isDir()) {
                                            if (!mkdir($target)) {
                                                echo "Failed to create directory: $target";
                                                return false;
                                            }
                                        } else {
                                            if (!copy($item, $target)) {
                                                echo "Failed to copy $item to $target";
                                                return false;
                                            }
                                        }
                                    }

                                    return true;
                                }

                                // Example usage:
                                $sourceDir = Yii::$app->params['datapath'] . '/share_safari_request/' . $id;
                                $destinationDir = Yii::$app->params['datapath'] . '/share_safari/' . $share_safari->id;

                                try {
                                    if (copyDirectory($sourceDir, $destinationDir)) {
                                        echo "Directory copied successfully.";
                                    } else {
                                        echo "Failed to copy directory.";
                                    }
                                } catch (Exception $e) {
                                    echo "Error: " . $e->getMessage();
                                }

                                $model->share_safari_request_approval_model->share_safari_id = $share_safari->id;
                                $model->share_safari_request_approval_model->save(false);
                            }
                        } else if ($model->is_approved == 0) {
                            $reason = MasterShareSafariReason::find()->select('reason')->where(['id' => $model->share_safari_request_approval_model->id])->one();
                            $user = $share_safari_request_approval_model->user;
                            $to_mail = $user->email;
                            $subject = 'Safari Reject Reason';
                            $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_REJECT_SHARE_SAFARI;
                            $req = ['username' => $user->name, 'reason' => $reason];
                            MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                        }

                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['view', 'id' => $id]);
                    }
                }
            }
        } else {
            $model->share_safari_request_approval_model->loadDefaultValues();
        }
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    public function findModel($id)
    {
        if ($model = ShareSafariRequest::find()->limit(1)->one()) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
