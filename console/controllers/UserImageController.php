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


    public function actionAvatarContent()
    {
        $users = User::find()->all();

        foreach ($users as $user) {
            if (!empty($user->avatar)) {
                $fileName = $user->id . '_google_avatar' . '.jpg';

                $url = $user->avatar;
                $content = @file_get_contents($url);

                if ($content === false) {
                    continue;
                }

                $tempPath = tempnam(sys_get_temp_dir(), $user->id . '_google_avatar') . '.jpg';
                file_put_contents($tempPath, $content);
               
                $uploadedFile = new \yii\web\UploadedFile([
                    'name' => $fileName,
                    'tempName' => $tempPath,
                    'type' => 'image/jpg',
                    'size' => filesize($tempPath),
                    'error' => UPLOAD_ERR_OK,
                ]);

                $filePath = 'user/profile/' . $fileName;

                $avatar_image = \common\Helper\FsHelper::saveUploadedFile($uploadedFile, $filePath, $fileName);

                $user->google_avatar_image = $fileName;
                $user->save(false);

                @unlink($tempPath);
            }
        }

        echo "Done";
    }
}
