<?php

namespace frontend\controllers;

use common\models\cms\faqs\Faqs;
use common\models\cms\faqcategory\FaqCategory;


/**
 * DefaultController.
 */
class FaqController extends FrontendBaseController
{
    /**
     * Displays Safari tour form Page.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $faq_categories = FaqCategory::find()->where(['status' => 1, 'id' => Faqs::find()->where(['status' => 1])->select(['category_id'])->distinct()->column()])->all();
        return $this->render('index', [
            'faq_categories' => $faq_categories
        ]);
    }
}
