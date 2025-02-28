<?php

namespace common\models\urlshortner\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\urlshortner\UrlShortner;

class UrlShortnerForm extends model
{
    public $url_shortner_model;
    public $shortner_url;
    public $short_id;
    public $code;
    public $alias;
    public $status;
    public $status_option;


    public function __construct(UrlShortner $url_shortner_model = null)
    {

        $this->url_shortner_model = Yii::createObject([
            'class' => UrlShortner::className()
        ]);



        if ($url_shortner_model  != '') {
            $this->url_shortner_model = $url_shortner_model;

            $this->shortner_url = $this->url_shortner_model->shortner_url;
            $this->short_id = $this->url_shortner_model->short_id;
            $this->code = $this->url_shortner_model->code;
            $this->alias = $this->url_shortner_model->alias;
            $this->status = $this->url_shortner_model->status;
        }

        $this->status_option = GeneralModel::newstatusoption();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alias'], 'default', 'value' => null],
            [['code'], 'default', 'value' => 302],
            [['shortner_url'], 'required'],
            [['shortner_url'], 'string'],
            [['code'], 'integer'],
            [['short_id', 'alias'], 'string', 'max' => 10],
            [['short_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shortner_url' => 'Shortner Url',
            'short_id' => 'Short ID',
            'code' => 'Code',
            'alias' => 'Alias',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->url_shortner_model->shortner_url = $this->shortner_url;
        $this->url_shortner_model->short_id = $this->generateUniqueShortId();
        $this->url_shortner_model->code = $this->code;
        $this->url_shortner_model->alias = $this->alias;
        $this->url_shortner_model->status = $this->status;
    }


    private function generateUniqueShortId()
    {
        do {
            $shortId = Yii::$app->security->generateRandomString(6);
        } while ($this->url_shortner_model::find()->where(['short_id' => $shortId])->exists());

        return $shortId;
    }
}
