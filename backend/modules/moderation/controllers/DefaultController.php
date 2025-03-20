<?php

namespace backend\modules\moderation\controllers;

use common\models\moderation\form\ModerationForm;
use common\models\moderation\Moderation;
use common\models\moderation\VideoAudioMetaData;
use common\models\moderation\VideoFormat;
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
                            $this->getVideoFormat(Yii::$app->params['cloud_front_url'] . $model->moderation_model->video_url, $model->moderation_model->id);
                            $this->getVideoStream(Yii::$app->params['cloud_front_url'] . $model->moderation_model->video_url, $model->moderation_model->id);
                            $this->getVideoAudioStream(Yii::$app->params['cloud_front_url'] . $model->moderation_model->video_url, $model->moderation_model->id);
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

    public function getVideoFormat($videoFilePath, $id)
    {
        $ffprobe = FFProbe::create();
        $video_duration = $ffprobe->format($videoFilePath);
        if ($video_duration) {
            $video_format = new VideoFormat();
            $video_format->moderation_id = $id;
            $video_format->nb_streams = $video_duration->get('nb_streams');
            $video_format->nb_programs = $video_duration->get('nb_programs');
            $video_format->format_name = $video_duration->get('format_name');
            $video_format->format_long_name = $video_duration->get('format_long_name');
            $video_format->start_time = $video_duration->get('start_time');
            $video_format->duration = $video_duration->get('duration');
            $video_format->size = $video_duration->get('size');
            $video_format->bit_rate = $video_duration->get('bit_rate');
            $video_format->probe_score = $video_duration->get('probe_score');
            $video_format->tags = $video_duration->get('tags');
            $video_format->save(false);
            return true;
        }

        return null;
    }

    public function getVideoStream($videoFilePath, $id)
    {
        $ffprobe = FFProbe::create();
        $streams = $ffprobe->streams($videoFilePath);
        foreach ($streams as $stream) {
            if ($stream->isVideo()) {
                $video_meta_data = new VideoMetadata();
                $video_meta_data->moderation_id = $id;
                $video_meta_data->duration = $stream->get('duration');
                $video_meta_data->r_frame_rate = $stream->get('r_frame_rate');
                $video_meta_data->average_frame_rate = $stream->get('avg_frame_rate');
                $video_meta_data->codec_name = $stream->get('codec_name');
                $video_meta_data->codec_long_name = $stream->get('codec_long_name');
                $video_meta_data->profile = $stream->get('profile');
                $video_meta_data->codec_type = $stream->get('codec_type');
                $video_meta_data->codec_tag_string = $stream->get('codec_tag_string');
                $video_meta_data->codec_tag = $stream->get('codec_tag');
                $video_meta_data->width = $stream->get('width');
                $video_meta_data->height = $stream->get('height');
                $video_meta_data->coded_width = $stream->get('coded_width');
                $video_meta_data->coded_height = $stream->get('coded_height');
                $video_meta_data->closed_captions = $stream->get('closed_captions');
                $video_meta_data->has_b_frames = $stream->get('has_b_frames');
                $video_meta_data->pix_fmt = $stream->get('pix_fmt');
                $video_meta_data->level = $stream->get('level');
                $video_meta_data->chroma_location = $stream->get('chroma_location');
                $video_meta_data->refs = $stream->get('refs');
                $video_meta_data->is_avc = $stream->get('is_avc');
                $video_meta_data->nal_length_size = $stream->get('nal_length_size');
                $video_meta_data->time_base = $stream->get('time_base');
                $video_meta_data->start_pts = $stream->get('start_pts');
                $video_meta_data->start_time = $stream->get('start_time');
                $video_meta_data->duration_ts = $stream->get('duration_ts');
                $video_meta_data->bit_rate = $stream->get('bit_rate');
                $video_meta_data->bits_per_raw_sample = $stream->get('bits_per_raw_sample');
                $video_meta_data->nb_frames = $stream->get('nb_frames');
                $video_meta_data->disposition = $stream->get('disposition');
                $video_meta_data->tags = $stream->get('tags');
                $video_meta_data->save(false);
                return true;
            }
        }
        return null;
    }

    public function getVideoAudioStream($videoFilePath, $id)
    {
        $ffprobe = FFProbe::create();
        $streams = $ffprobe->streams($videoFilePath);
        foreach ($streams as $stream) {
            if ($stream->isAudio()) {
                $video_audio_meta_data = new VideoAudioMetaData();
                $video_audio_meta_data->moderation_id = $id;
                $video_audio_meta_data->codec_name = $stream->get('codec_name');
                $video_audio_meta_data->codec_long_name = $stream->get('codec_long_name');
                $video_audio_meta_data->profile = $stream->get('profile');
                $video_audio_meta_data->codec_type = $stream->get('codec_type');
                $video_audio_meta_data->codec_tag_string = $stream->get('codec_tag_string');
                $video_audio_meta_data->codec_tag = $stream->get('codec_tag');
                $video_audio_meta_data->sample_fmt = $stream->get('sample_fmt');
                $video_audio_meta_data->sample_rate = $stream->get('sample_rate');
                $video_audio_meta_data->channels = $stream->get('channels');
                $video_audio_meta_data->channel_layout = $stream->get('channel_layout');
                $video_audio_meta_data->bits_per_sample = $stream->get('bits_per_sample');
                $video_audio_meta_data->r_frame_rate = $stream->get('r_frame_rate');
                $video_audio_meta_data->avg_frame_rate = $stream->get('avg_frame_rate');
                $video_audio_meta_data->time_base = $stream->get('time_base');
                $video_audio_meta_data->start_pts = $stream->get('start_pts');
                $video_audio_meta_data->start_time = $stream->get('start_time');
                $video_audio_meta_data->duration_ts = $stream->get('duration_ts');
                $video_audio_meta_data->duration = $stream->get('duration');
                $video_audio_meta_data->bit_rate = $stream->get('bit_rate');
                $video_audio_meta_data->nb_frames = $stream->get('nb_frames');
                $video_audio_meta_data->disposition = $stream->get('disposition');
                $video_audio_meta_data->tags = $stream->get('tags');
                $video_audio_meta_data->save(false);
                return true;
            }
        }
        return null;
    }
}
