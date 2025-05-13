<?php

namespace console\controllers;

use common\models\package\Package;
use common\models\package\PackageVersion;
use Yii;
use yii\console\Controller;



/**
 * PackageAssignController
 */
class PackageAssignController extends Controller
{
    public function actionPackage()
    {

        $ids = [76, 23, 4, 3];
        $package_model = Package::find()->andWhere(['not in', 'owned_by_id', $ids])->all();
        foreach ($package_model as $package) {
            $randomKey = array_rand($ids);
            $package->owned_by_id = $ids[$randomKey];
            if ($package->save(false)) {
                $package_version_model = PackageVersion::find()->where(['package_id' => $package->id])->all();
                foreach ($package_version_model as $pack) {

                    $pack->owned_by_id = $package->owned_by_id;
                    $pack->save(false);
                }
            }
        }
    }
}
