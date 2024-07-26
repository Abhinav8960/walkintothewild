<?php

namespace frontend\modules\package\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use common\models\UserWishlist;
use common\models\package\Package;
use yii\web\NotFoundHttpException;
use frontend\models\PackageQuoteForm;
use frontend\models\PackageReplyForm;
use common\interfaces\StatusInterface;
use frontend\models\PackageCommentForm;
use common\models\package\PackageSearch;
use common\models\package\PackageFeature;
use common\models\operator\SafariOperator;
use common\models\package\form\PackageForm;
use common\models\package\PackageComment;
use common\models\package\PackageFaqSearch;
use common\models\package\PackageSafariPark;
use frontend\controllers\FrontendBaseController;
use frontend\models\form\PackageEnquiryForm;
use frontend\models\PackageCommentReportForm;

/**
 * DefaultController.
 */
class DefaultController extends FrontendBaseController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PackageSearch();
        $searchModel->estimated_price_filter_min = 1000;
        $searchModel->estimated_price_filter_max = 500000;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $models = $dataProvider->getModels();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'models' => $models,
        ]);
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView($slug)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (empty($package)) {
            return $this->redirect(['/package']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $searchModel = new PackageFaqSearch();
        $searchModel->package_id = $package->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);
        $faqs = $dataProvider->getModels();


        $model = new PackageCommentForm();
        $replymodel = new PackageReplyForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->comment($package)) {
            Yii::$app->session->setFlash('success', 'Comment Successfully submitted');
            return $this->redirect(\yii\helpers\Url::toRoute(['/package/' . $package->package_slug . '']));
        }


        if ($replymodel->load(Yii::$app->request->post()) && $replymodel->validate() && $replymodel->reply($package)) {
            Yii::$app->session->setFlash('success', 'Reply Successfully submitted');
            return $this->redirect(['/package/' . $package->package_slug . '']);
        }




        $packagemodel = new PackageQuoteForm();

        $packagemodel->action_validate_url = '/package/default/validate';
        if ($packagemodel->load(Yii::$app->request->post()) && $packagemodel->validate() && $packagemodel->request($package->id)) {
            Yii::$app->session->setFlash('success', 'quote Requested Successfully submitted');
            return $this->redirect(['/package/' . $package->package_slug . '']);
        }

        return $this->render(
            'view',
            [
                'package' => $package,
                'faqs' => $faqs,
                'model' => $model,
                'replymodel' => $replymodel,
                'packagemodel' => $packagemodel,
            ]
        );
    }


    /**
     * Validate 
     *
     * @param [type] $id
     * @return void
     */
    public function actionValidate($id = null)
    {
        $packagemodel = new PackageQuoteForm();
        if ($id != null) {
            $formmodel = $this->findModel($id);
            $packagemodel = new PackageQuoteForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $packagemodel->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($packagemodel);
        }
    }


    /**
     * Add To Wishlist Package
     */
    public function actionWishlist($slug)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (empty($package)) {
            return $this->redirect(['/package']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if ($package) {
            if (Yii::$app->user->identity) {
                $wishlist = UserWishlist::find()->where(['user_id' => Yii::$app->user->identity->id, 'item_id' => $package->id, 'item_type_id' => UserWishlist::SAFARI_PACKAGE])->one();
                if (!$wishlist) {
                    $wishlist = new UserWishlist();
                }
                $wishlist->user_id = Yii::$app->user->identity->id;
                $wishlist->item_id = $package->id;
                $wishlist->item_type_id = UserWishlist::SAFARI_PACKAGE;
                $wishlist->item_type = 'package';
                $wishlist->status = 1;
                if ($wishlist->save(false)) {
                    Yii::$app->session->setFlash('success', 'You added ' . $package->package_name . ' to wishlist ');
                } else {
                    Yii::$app->session->setFlash('error', 'You can not add this package to wishlist currently!');
                }
            } else {
                return $this->redirect(['/site/auth?authclient=google&referrer=' . Url::toRoute(['/package/default/wishlist', 'slug' => $package->package_slug])]);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(\yii\helpers\Url::toRoute(['/package/default/index']));
    }

    public function actionUnwishlist($slug)
    {
        $package = Package::find()->where(['package_slug' => $slug])->limit(1)->one();
        if (empty($package)) {
            return $this->redirect(['/package']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if ($package) {
            if (Yii::$app->user->identity) {
                $wishlist = UserWishlist::find()->where(['user_id' => Yii::$app->user->identity->id, 'item_id' => $package->id, 'item_type_id' => UserWishlist::SAFARI_PACKAGE])->one();
                if ($wishlist) {
                    $wishlist->status = 0;
                    if ($wishlist->save(false)) {
                        Yii::$app->session->setFlash('success', 'You removed ' . $package->package_name . ' from wishlist ');
                    } else {
                        Yii::$app->session->setFlash('error', 'You can not add this package to wishlist currently!');
                    }
                }
            } else {
                return $this->redirect(['/site/auth?authclient=google&referrer=' . Url::toRoute(['/package/default/wishlist', 'slug' => $package->package_slug])]);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(\yii\helpers\Url::toRoute(['/package/default/index']));
    }


    public function actionEnquiry($slug)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        $model = new PackageEnquiryForm();
        $model->safari_operator_id =  $package->owned_by_id;
        $model->package_id = $package->id;
        $model->status = 1;
        if (Yii::$app->user->identity) {
            $model->user_id = Yii::$app->user->identity->id;
            $model->name = Yii::$app->user->identity->name;
            $model->email_address = Yii::$app->user->identity->email;
            $model->phone = Yii::$app->user->identity->mobile_no;
        }
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_enquiry_model->save(false)) {
                        Yii::$app->session->setFlash('success', 'Request Sent Successfully!');
                        return $this->redirect(['view', 'slug' => $package->package_slug]);
                    }
                }
            }
        } else {
            $model->package_enquiry_model->loadDefaultValues();
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_enquiry_form', [
                'model' => $model
            ]);
        } else {
            return $this->renderAjax('_enquiry_form', [
                'model' => $model
            ]);
        }
    }


    public function actionFlag($slug, $package_comment_id)
    {
        $package = Package::find()->where(['package_slug' => $slug])->one();
        if (!$package) {
            return $this->redirect(['/package']);
        }

        $comments = PackageComment::find()->where(['id' => $package_comment_id])->limit(1)->one();

        $model = new PackageCommentReportForm();
        $model->package_id = $package->id;
        $model->package_comment_id = $package_comment_id;

        $model->action_url = '/package/default';
        $model->action_validate_url = '/package/default/validateflag';
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->flag_model->save(false)) {
                        $comments->flaged = 1;
                        $comments->save(false);
                        Yii::$app->session->setFlash('success', 'Review Reported Successfully!');
                        return $this->redirect(['/package/default/view',  'slug' => $slug, '#' => 'commentform-comment']);
                    }
                }
            }
        } else {
            $model->flag_model->loadDefaultValues();
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_flag_form', [
                'model' => $model,
                'slug' => $slug,
                'comments' => $comments,
            ]);
        }
    }

    public function actionValidateflag($id = null)
    {
        $model = new PackageCommentReportForm();
        if ($id != null) {
            $flag_model = $this->findModel($id);
            $model = new PackageCommentReportForm($flag_model);
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    /**
     * Get Redirect URL
     */
    public function actionGeturl()
    {
        if (Yii::$app->request->isPost) {
            // Initialize URL with the base route
            $url = ['/package'];

            // Loop through the payload parameters
            foreach (Yii::$app->request->post('PackageSearch') as $key => $value) {
                // Only add parameters that are not empty
                if (!empty($value)) {
                    $url['PackageSearch[' . $key . ']'] = $value;
                } else {
                    // $url['SafariParkSearch[' . $key . ']'] = 0;
                }
            }

            // Construct the redirect URL
            return \yii\helpers\Url::to($url);
        }
    }
}
