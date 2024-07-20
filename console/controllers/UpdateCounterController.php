<?php

namespace console\controllers;

use common\models\article\article\Article;
use common\models\trierror\FrontendRequestLog;
use yii\console\Controller;



/**
 * Main Controller for YII Console
 */
class UpdateCounterController extends Controller
{
  public function actionIndex()
  {
    //article counter
    $article_slugs = FrontendRequestLog::find()
      ->select(['slug', 'route', 'COUNT(*) AS pending_view'])
      ->where(['not', ['slug' => null]])
      ->andWhere(['is_count' => false])
      ->andWhere(['route' => 'article/default/view' ])
      ->groupBy(['slug'])
      ->createCommand()
      ->queryAll();

    if(count($article_slugs)){
        foreach($article_slugs as $article){ 
            $atricle_model = Article::find()->where(['slug' => $article['slug']])->one();
            $atricle_model->total_view += $article['pending_view'];
            if($atricle_model->save()){
                FrontendRequestLog::updateAll(['is_count' => true], ['slug' => $article['slug']]);
            }
        }
    }

    //topic counter
    $topic_slugs = FrontendRequestLog::find()
      ->select(['slug', 'route', 'COUNT(*) AS pending_view'])
      ->where(['not', ['slug' => null]])
      ->andWhere(['is_count' => false])
      ->andWhere(['route' => 'article/default/topic' ])
      ->groupBy(['slug'])
      ->createCommand()
      ->queryAll();

    if(count($topic_slugs)){
      foreach($topic_slugs as $topic){ 
        $topic_model = MasterArticleTopic::find()->where(['slug' => $topic['slug']])->one();
        $topic_model->total_view += $topic['pending_view'];
        if($topic_model->save()){
            FrontendRequestLog::updateAll(['is_count' => true], ['slug' => $topic['slug']]);
        }
      }
    }

    //tag counter
    $tag_slugs = FrontendRequestLog::find()
      ->select(['slug', 'route', 'COUNT(*) AS pending_view'])
      ->where(['not', ['slug' => null]])
      ->andWhere(['is_count' => false])
      ->andWhere(['route' => 'article/default/tag' ])
      ->groupBy(['slug'])
      ->createCommand()
      ->queryAll();

    if(count($tag_slugs)){
      foreach($tag_slugs as $tag){ 
        $tag_model = MasterArticleTag::find()->where(['slug' => $tag['slug']])->one();
        $tag_model->total_view += $tag['pending_view'];
        if($tag_model->save()){
            FrontendRequestLog::updateAll(['is_count' => true], ['slug' => $tag['slug']]);
        }
      }
    }
  }
}