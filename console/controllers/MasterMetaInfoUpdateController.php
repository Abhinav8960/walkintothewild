<?php

namespace console\controllers;

use common\models\MailLog;
use common\models\MailLogRecipients;
use common\models\master\email\MasterMailTemplate;
use yii\console\Controller;



/**
 * Main Controller for YII Console
 */
class MasterMetaInfoUpdateController extends Controller
{


    public function actionIndex()
    {
        $master_arr = [
            '\common\models\master\airport\MasterAirport',
            '\common\models\master\animal\MasterAnimal',
            '\common\models\master\bird\MasterBird',
            '\common\models\master\bonusexperience\MasterBonusExperience',
            '\common\models\master\city\MasterCity',
            '\common\models\master\country\MasterCountry',
            '\common\models\master\faq\MasterFaq',
            '\common\models\master\location\MasterLocation',
            '\common\models\master\operatorcategory\MasterOperatorCategory',
            '\common\models\master\packagefeature\MasterPackagefeature',
            '\common\models\master\packageinclude\MasterPackageInclude',
            '\common\models\master\railwaystation\MasterRailwayStation',
            '\common\models\master\sharesafarireason\MasterShareSafariReason',
            '\common\models\master\state\MasterState',
            '\common\models\master\suggetioncategory\MasterSuggestionCategory',
            '\common\models\master\vehicle\MasterVehicle'
        ];

        $meta_arr = [
            '\common\models\meta\MetaAccommodation',
            '\common\models\meta\MetaAnimalType',
            '\common\models\meta\MetaBirdType',
            // '\common\models\meta\MetaLocation',
            '\common\models\meta\MetaOperatorCredibility',
            '\common\models\meta\MetaOtherWildlifeActivities',
            '\common\models\meta\MetaPackageRange',
            '\common\models\meta\MetaParkTripSlot',
            '\common\models\meta\MetaSafariSession',
            '\common\models\meta\MetaStayCategory',
            '\common\models\meta\MetaTermConditionType',
            '\common\models\meta\MetaWildLifeType',
            '\common\models\meta\MetaZoneType',
        ];

        foreach ($master_arr as $ar) {
            $className = substr($ar, strrpos($ar, '\\') + 1);
            \common\models\MasterMetaTableInfo::upsert($className, $ar::find()->where(['status'=>1])->count(), $ar::find()->max('updated_at'));
        }

        foreach ($meta_arr as $ar) {
            $className = substr($ar, strrpos($ar, '\\') + 1);
            \common\models\MasterMetaTableInfo::upsert($className, $ar::find()->count(), $ar::find()->max('updated_at'));
        }
    }
}
