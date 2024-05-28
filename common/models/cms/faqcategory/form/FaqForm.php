<?php

namespace common\models\cms\faqcategory\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\cms\faqcategory\Faq;

/**
 * Class Faq
 * @package common\models\cms\faq_category\form
 *
 * Handles the creation and updating of Faq models
 */
class FaqForm extends Model
{
    public $name;
    public $status;
    public $status_option = [];
    public $faq_model;

    public function __construct(Faq $faq_model = null, $config = [])
    {
        parent::__construct($config);

        if ($faq_model === null) {
            $this->faq_model = new Faq();
        } else {
            $this->faq_model = $faq_model;
            $this->name = $this->faq_model->name;
            $this->status = $this->faq_model->status;
        }

        $this->status_option = GeneralModel::statusOption();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 251],        
            [['status'], 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'status' => 'Status',
        ];
    }

    /**
     * Initialize form values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->faq_model->name = $this->name;
        $this->faq_model->status = $this->status;
    }
}
