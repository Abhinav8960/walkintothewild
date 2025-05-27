<?php

namespace console\controllers;

use common\models\User;
use Yii;
use yii\console\Controller;

/**
 * UserImageController implements the CRUD actions for User model.
 */
class UserImageController extends Controller
{

    public function actionProfileImage()
    {
        $users = User::find()->all();
        $result = [];

        foreach ($users as $user) {
            if (!empty($user->profile_image)) {
                $sourcePath = 'user/' . $user->id . '/' . $user->profile_image;
                $extension = pathinfo($user->profile_image, PATHINFO_EXTENSION);

                $fileName = $user->id . '_profile_' . time() . '.' . $extension;
                $destinationPath = 'user/profile/' . $fileName;

                $exists = Yii::$app->fs->has($sourcePath);
                if (!empty($exists)) {

                    $copy = Yii::$app->fs->copy($sourcePath, $destinationPath);
                    $result[] = [
                        'user_id' => $user->id,
                        'exists' => $exists,
                        'sourcePath' => $sourcePath,
                        'destinationPath' => $destinationPath,
                        'copy' => $copy,
                        'fileName' => $fileName,
                    ];

                    $user->profile_image = $fileName;
                    $user->save(false);
                }
            }
        }
        print_r($result);
        echo "Done";

        return true;
    }

    public function actionCoverImage()
    {
        $users = User::find()->all();
        $result = [];

        foreach ($users as $user) {
            if (!empty($user->cover_image)) {
                $sourcePath = 'user_cover_image/' . $user->id . '/' . $user->cover_image;
                $extension = pathinfo($user->cover_image, PATHINFO_EXTENSION);

                $fileName = $user->id . '_cover_' . time() . '.' . $extension;
                $destinationPath = 'user/profile/' . $fileName;

                $exists = Yii::$app->fs->has($sourcePath);
                if (!empty($exists)) {

                    $copy = Yii::$app->fs->copy($sourcePath, $destinationPath);
                    $result[] = [
                        'user_id' => $user->id,
                        'exists' => $exists,
                        'sourcePath' => $sourcePath,
                        'destinationPath' => $destinationPath,
                        'copy' => $copy,
                        'fileName' => $fileName,
                    ];

                    $user->cover_image = $fileName;
                    $user->save(false);
                }
            }
        }
        print_r($result);
        echo "Done";

        return true;
    }

  
}
