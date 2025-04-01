<?php
// filepath: /home/ak/project/walkintothewild/common/behaviors/ModerationBehavior.php
namespace common\behaviors;

use common\models\feeds\Feeds;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class FeedsBehavior extends Behavior
{
    public $objective;
    public $collection;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'feeds',
            ActiveRecord::EVENT_AFTER_UPDATE => 'feeds',
        ];
    }

    public function feeds($event)
    {
        $model = Feeds::find()->where(['collection'=>$this->collection,'collection_id'=>$this->owner->id])->one();
        if(empty($model)){

            $model = new Feeds();
        }
        $model->objective = $this->objective;
        $model->collection = $this->collection;
        $model->collection_id = $this->owner->id;
        if($this->owner->status == NULL){
            $model->status = Feeds :: STATUS_ACTIVE;
        }else{
            $model->status = $this->owner->status;
        }
        $model->created_by = $this->owner->created_by;
        $model->updated_by = $this->owner->updated_by;
        $model->created_at = $this->owner->created_at;
        $model->updated_at = $this->owner->updated_at;
        
        $model->save(false);
    }
}