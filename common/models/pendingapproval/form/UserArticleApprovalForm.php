<?php

namespace common\models\pendingapproval\form;

use common\models\cms\article\Article;
use Yii;
use yii\base\Model;
use common\models\GeneralModel;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Approval
 */
class UserArticleApprovalForm extends model
{

    public $is_approved;
    public $status;
    public $status_option = [];
    public $user_article_approval_model;


    public function __construct(Article $user_article_approval_model = null)
    {

        $this->user_article_approval_model = Yii::createObject([
            'class' => Article::className()
        ]);



        if ($user_article_approval_model  != '') {
            $this->user_article_approval_model = $user_article_approval_model;
            $this->is_approved              =  $this->user_article_approval_model->is_approved;
            $this->status              =  $this->user_article_approval_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_approved', 'status'], 'integer'],
            [['is_approved'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_approved' => 'Is Approved',
            'status' => 'Status',
        ];
    }
    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->user_article_approval_model->is_approved          =  $this->is_approved;
        $this->user_article_approval_model->status               =  $this->status;
    }
}
