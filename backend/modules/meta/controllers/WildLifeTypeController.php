<?php

namespace backend\modules\meta\controllers;

use common\interfaces\StatusInterface;
use common\models\master\animal\form\MasterAnimalForm;
use common\models\master\animal\MasterAnimal;
use common\models\master\animal\MasterAnimalSearch;
use common\models\meta\MetaWildLifeType;
use yii\web\UploadedFile;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * WildLifeTypeController.
 */
class WildLifeTypeController extends Controller
{
    /**
     * Lists all MasterAnimal models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model =  MetaWildLifeType::find()->where(['status' => 1])->all();

        return $this->render('index', [
            'models' => $model,
        ]);
    }
}
