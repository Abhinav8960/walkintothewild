<?php

namespace common\models\cms\article\form;

use common\models\cms\article\Article;
use Yii;
use yii\base\Model;
use common\models\GeneralModel;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Approval
 */
class ArticleDeleteForm extends model
{


    public $status;
    public $delete_reason_id;
    public $delete_reason;
    public $status_option = [];
    public $delete_article_model;


    public function __construct(Article $delete_article_model = null)
    {

        $this->delete_article_model = Yii::createObject([
            'class' => Article::className()
        ]);



        if ($delete_article_model  != '') {
            $this->delete_article_model = $delete_article_model;
            $this->delete_reason_id              =  $this->delete_article_model->delete_reason_id;
            $this->delete_reason              =  $this->delete_article_model->delete_reason;
            $this->status              =  $this->delete_article_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['delete_reason'], 'string'],
            [['delete_reason_id', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',


        ];
    }
    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {

        $this->delete_article_model->delete_reason_id =    $this->delete_reason_id;
        $this->delete_article_model->delete_reason =  $this->delete_reason;
        $this->delete_article_model->status =  $this->status;
    }
}
