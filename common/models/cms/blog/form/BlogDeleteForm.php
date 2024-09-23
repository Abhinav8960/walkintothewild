<?php

namespace common\models\cms\blog\form;

use common\models\cms\blog\Blog;
use Yii;
use yii\base\Model;
use common\models\GeneralModel;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Approval
 */
class BlogDeleteForm extends model
{


    public $status;
    public $delete_reason_id;
    public $delete_reason;
    public $status_option = [];
    public $delete_blog_model;


    public function __construct(Blog $delete_blog_model = null)
    {

        $this->delete_blog_model = Yii::createObject([
            'class' => Blog::className()
        ]);



        if ($delete_blog_model  != '') {
            $this->delete_blog_model = $delete_blog_model;
            $this->delete_reason_id              =  $this->delete_blog_model->delete_reason_id;
            $this->delete_reason              =  $this->delete_blog_model->delete_reason;
            $this->status              =  $this->delete_blog_model->status;
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

        $this->delete_blog_model->delete_reason_id =    $this->delete_reason_id;
        $this->delete_blog_model->delete_reason =  $this->delete_reason;
        $this->delete_blog_model->status =  $this->status;
    }
}
