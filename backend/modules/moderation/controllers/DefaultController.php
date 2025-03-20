<?php

namespace backend\modules\moderation\controllers;

use common\models\moderation\form\ModerationForm;
use common\models\moderation\Moderation;
use common\models\moderation\VideoMetadata;
use FFMpeg\FFProbe;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

/**
 * DefaultController.
 */
class DefaultController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $query = Moderation::find();

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreate()
    {
        $model = new ModerationForm();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->video = UploadedFile::getInstance($model, 'video');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->moderation_model->save()) {
                        $model->uploadFile();
                        if ($model->moderation_model->type == 1) {
                            Yii::$app->moderation->textFeedback($model->moderation_model->text, $model->moderation_model->id);
                            \Yii::$app->session->setFlash('success', 'Extracted Successfully');
                        } elseif ($model->moderation_model->type == 2) {
                            $video_meta_data_model = new VideoMetadata();
                            $video_meta_data_model->size = $model->video->size;
                            $video_meta_data_model->moderation_id = $model->moderation_model->id;
                            $video_meta_data_model->duration = $this->getVideoDuration(Yii::$app->params['cloud_front_url'] . $model->moderation_model->video_url);
                            $video_meta_data_model->r_frame_rate = $this->getVideoFramerate(Yii::$app->params['cloud_front_url'] . $model->moderation_model->video_url);
                            $video_meta_data_model->average_frame_rate = $this->getVideoAvgFramerate(Yii::$app->params['cloud_front_url'] . $model->moderation_model->video_url);
                            $video_meta_data_model->save(false);
                            Yii::$app->moderation->videoFeedback($model->moderation_model->video_url, $model->moderation_model->id);
                            \Yii::$app->session->setFlash('success', 'Extracted Successfully');
                        } elseif ($model->moderation_model->type == 3) {
                            Yii::$app->moderation->imageFeedback($model->moderation_model->image_url, $model->moderation_model->id);
                            \Yii::$app->session->setFlash('success', 'Extracted Successfully');
                        }
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->moderation_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function getVideoDuration($videoFilePath)
    {
        $ffprobe = FFProbe::create();
        $video_duration = $ffprobe
            ->format($videoFilePath)
            ->get('duration');
        return $video_duration;
    }

    public function getVideoFramerate($videoFilePath)
    {
        $ffprobe = FFProbe::create();
        $streams = $ffprobe->streams($videoFilePath);
        foreach ($streams as $stream) {
            if ($stream->isVideo()) {
                $frameRate = $stream->get('r_frame_rate');
                return $frameRate;
            }
        }
        return null;
    }

    public function getVideoAvgFramerate($videoFilePath)
    {
        $ffprobe = FFProbe::create();
        $streams = $ffprobe->streams($videoFilePath);
        foreach ($streams as $stream) {
            if ($stream->isVideo()) {
                $frameRate = $stream->get('avg_frame_rate');
                return $frameRate;
            }
        }
        return null;
    }
}
