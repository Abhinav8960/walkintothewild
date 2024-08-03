<?php

namespace common\models\cms\faqs;

//use common\models\cms\faqcategory\Faq;
//use common\models\cms\faqcategory\Faq;
use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "faqs".
 *
 * @property string $category_id
 * @property string $question
 * @property string $answer
 * @property int $status
 */
class Faqs extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faqs';
    }



    /**
     * {@inheritdoc}
     */

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id','question','answer'], 'required'],
            [['status'], 'integer'],
            [['question'], 'string', 'max' => 512],
            [['answer'], 'validateMaxWords', 'params' => ['max' => 100]],
            
        ];
    }
    public function validateMaxWords($attribute, $params)
    {
        $maxWords = $params['max'];
        $wordCount = str_word_count($this->$attribute);
        if ($wordCount > $maxWords) {
            $this->addError($attribute, "The $attribute must not exceed $maxWords words.");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category',
            'question' => 'Question',
            'answer' => 'Answer',
            'status' => 'Status',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(\common\models\cms\faqcategory\FaqCategory::className(), ['id' => 'category_id']);
    }
}
