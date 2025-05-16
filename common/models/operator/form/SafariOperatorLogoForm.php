<?php

namespace common\models\operator\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\operator\SafariOperator;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Safari Operator
 */
class SafariOperatorLogoForm extends model
{

    public $safari_operator_logo_model;
    public $logo;

    public function __construct(SafariOperator $safari_operator_logo_model)
    {

        $this->safari_operator_logo_model = Yii::createObject([
            'class' => SafariOperator::className()
        ]);

        if ($safari_operator_logo_model  != '') {
            $this->safari_operator_logo_model = $safari_operator_logo_model;
            $this->logo = $this->safari_operator_logo_model->logo;
        }
    }


    /**
     * {@inheritdoc}is_offer_premium_budget
     */
    public function rules()
    {
        return [[
            ['logo'],
            'image',
            'extensions' => ['jpeg', 'jpg', 'png'],
            'maxSize' => 250 * 1024
        ]];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'logo' => 'Logo',
        ];
    }

    public function uploadFile()
    {

        if ($this->logo) {
            $storagePath = Yii::$app->params['datapath'] . '/safarioperator';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->safari_operator_logo_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'safarioperator' . time() . '.' . $this->logo->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->logo->saveAs($filePath)) {
                $this->safari_operator_logo_model->logo = $fileName;
                $this->safari_operator_logo_model->save(false);
            }
        }
    }
}
