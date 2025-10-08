<?php

namespace api\models\compliancedocuments;

use Yii;

class ComplianceDocuments extends \common\models\compliancedocuments\ComplianceDocuments
{
    public function fields()
    {
        $fields = [
            'id',
            'version',
            'title',
            'content',
            'effective_date',
            'imagebannerpath'
        ];
        // $fields[] = 'Compliance Documents';
        return $fields;
    }

    public function getTitle()
    {
        if($this->type == 1){
            return "Terms and Conditions";
        }
        elseif($this->type == 2){
            return "Privacy Policy";
        }
        elseif($this->type == 3){
            return "Refund Policy";
        }
        else{
            return "";
        }
    }

    // public function getImagebannerpath()
    // {
    //     $image_path = '';
    //     if (isset($this->banner_image)) {
    //         $image_path = \Yii::$app->params['s3_endpoint'] . '/' . $this->banner_image;
    //     } else {
    //         return '';
    //     }
    //     return $image_path;
    // }
}
