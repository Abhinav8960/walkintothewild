<?php

namespace common\models\article\category\form;

use common\models\article\category\Category;
use common\models\GeneralModel;
use Yii;
use yii\base\Model;

/**
 * Class CategoryForm
 * @package common\models\category\form
 */
class CategoryForm extends Model
{
    public $category;
    public $status;
    public $status_option = [];

    /**
     * @var Category|null
     */
    public $category_model;

    /**
     * CategoryForm constructor.
     * @param Category|null $category_model
     * @param array $config
     */
    public function __construct($category_model = null, $config = [])
    {
        $this->category_model = Yii::createObject([
            'class' => Category::className()
        ]);

        if ($category_model !== null) {
            $this->category_model = $category_model;
            $this->category = $this->category_model->category;
            $this->status = $this->category_model->status;
        }

        $this->status_option = GeneralModel::statusoption() ?: [];

        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['category', 'status'], 'required'],
            [['status'], 'integer'],
            [['category'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'category' => 'Category',
            'status' => 'Status',
        ];
    }

    /**
     * Initializes the form model's category model with the current form data.
     */
    public function initializeForm()
    {
        $this->category_model->category = $this->category;
        $this->category_model->status = $this->status;
    }
}
