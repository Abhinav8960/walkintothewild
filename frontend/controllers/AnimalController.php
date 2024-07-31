<?php

namespace frontend\controllers;

use Yii;
use common\models\master\animal\MasterAnimal;

class AnimalController extends FrontendBaseController
{
  public function actionIndex($animal, $slug)
  {
    $animal = MasterAnimal::find()->where(['status' => true])->andWhere(['slug' => $slug])->one();
    if ($animal) {
      //rediret to plan safari search page
      return $this->redirect(['/parklist?SafariParkSearch%5Bmaster_animal_id%5D=' . $animal['id']]);
    } else {
      //redirect to home page
      return $this->redirect(['/']);
    }
  }
}
