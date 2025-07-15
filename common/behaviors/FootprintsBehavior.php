<?php
// filepath: /home/ak/project/walkintothewild/common/behaviors/ModerationBehavior.php
namespace common\behaviors;

use common\models\feeds\Feeds;
use common\models\trackings\Footprints;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class FootprintsBehavior extends Behavior
{
    public $objective;
    public $collection;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'acumen',
            // ActiveRecord::EVENT_AFTER_UPDATE => 'acumen',
        ];
    }

    public function acumen($event)
    {

        $headers = Yii::$app->getRequest()->getHeaders();
        $device = strtolower($headers->get('x-device')) ?? null;
        $platform = strtolower($headers->get('x-platform')) ?? null;
        $platform_version = strtolower($headers->get('x-platform-version')) ?? null;
        $application_version = strtolower($headers->get('x-application-version')) ?? null;
        $browser = strtolower($headers->get('x-browser')) ?? null;
        $browser_version = strtolower($headers->get('x-browser_version')) ?? null;

        $model = new Footprints();
        $model->objective = $this->objective;
        $model->collection = $this->collection;
        $model->collection_id = $this->owner->id;
        $model->action = \Yii::$app->controller->action->id;
        $model->absolute_url = \Yii::$app->request->absoluteUrl;
        $model->date_time = date('Y-m-d H:i:s');
        $model->device = $device;
        $model->platform = $platform;
        $model->platform_version = $platform_version;
        $model->browser = $browser;
        $model->browser_version = $browser_version;
        $model->application_version = $application_version;
        $model->created_by = $this->owner->created_by;
        $model->updated_by = $this->owner->updated_by;
        $model->created_at = $this->owner->created_at;
        $model->updated_at = $this->owner->updated_at;
        $model->save(false);
    }
}
