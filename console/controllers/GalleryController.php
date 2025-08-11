<?php

namespace console\controllers;

use common\models\partnergallery\PartnerGallery;
use common\models\partnergallery\PartnerGalleryVersion;
use Yii;
use yii\console\Controller;


class GalleryController extends Controller
{

    public function actionStep1()
    {
        $db = Yii::$app->db;

        $transaction = $db->beginTransaction();
        try {
            // Drop copy tables if they exist
            $db->createCommand("DROP TABLE IF EXISTS backup_partner_gallery")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_partner_gallery_image")->execute();
            $db->createCommand("DROP TABLE IF EXISTS backup_partner_gallery_version")->execute();


            // Create structure from original tables
            $db->createCommand("CREATE TABLE backup_partner_gallery LIKE partner_gallery")->execute();
            $db->createCommand("CREATE TABLE backup_partner_gallery_image LIKE partner_gallery_image")->execute();
            $db->createCommand("CREATE TABLE backup_partner_gallery_version LIKE partner_gallery_version")->execute();


            // Insert data into new tables
         
            $db->createCommand("INSERT INTO backup_partner_gallery SELECT * FROM partner_gallery")->execute();
            $db->createCommand("INSERT INTO backup_partner_gallery_image SELECT * FROM partner_gallery_image")->execute();
            $db->createCommand("INSERT INTO backup_partner_gallery_version SELECT * FROM partner_gallery_version")->execute();


            $transaction->commit();
            echo "Tables duplicated successfully.";
        } catch (\Exception $e) {
            $transaction->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }

    public function actionStep2()
    {
        $partner_galleries = PartnerGallery::find()->where(['is_live' => 1, 'in_draft' => 1])->andWhere(['!=', 'status', -1])->all();
        foreach ($partner_galleries as $gallery) {
            $gallery->listing_status = 1;
            $gallery->edit_status = 1;
            $gallery->save(false);
        }
    }

    public function actionStep3()
    {
        $partner_galleries = PartnerGallery::find()->where(['is_live' => 1, 'status' => 1])->all();
        foreach ($partner_galleries as $gallery) {
            $gallery->listing_status = 1;
            $gallery->edit_status = 0;
            $gallery->save(false);
        }
    }

    public function actionStep4()
    {
        $distinctPartnerGalleryIds = PartnerGalleryVersion::find()
            ->select('partner_gallery_id')
            ->distinct()
            ->column();

        foreach ($distinctPartnerGalleryIds as $partnerGalleryId) {
            $lastVersion = PartnerGalleryVersion::find()
                ->where(['partner_gallery_id' => $partnerGalleryId])
                ->orderBy(['version' => SORT_DESC])
                ->one();

            if ($lastVersion) {
                $partnerGallery = PartnerGallery::findOne($partnerGalleryId);
                if ($partnerGallery) {
                    $partnerGallery->version = $lastVersion->version;
                    $partnerGallery->save(false);
                    echo "Updated partner gallery ID {$partnerGalleryId} to version {$lastVersion->version}\n";
                }
            }
        }

        echo "Step 4 completed: All partner galleries updated to their latest versions.\n";
    }
}
