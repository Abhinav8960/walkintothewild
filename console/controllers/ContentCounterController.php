<?php

namespace console\controllers;

use yii\console\Controller;
use common\models\trierror\FrontendRequestLog;
use common\models\trierror\FrontendRequestLogSearch;
use common\models\cms\article\Article;
use common\models\cms\article\MasterArticleTopic;
use common\models\cms\article\MasterArticleTag;
use common\models\park\Park;
use common\models\operator\SafariOperator;
use common\models\trierror\SitePages;
use common\models\cms\article\ArticleAuthor;
use common\models\sharesafari\ShareSafari;

/**
 * Main Controller for YII Console
 */
class ContentCounterController extends Controller
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

    //Park counter
    $park_slugs = FrontendRequestLog::find()
      ->select(['slug', 'route', 'COUNT(*) AS pending_view'])
      ->where(['not', ['slug' => null]])
      ->andWhere(['is_count' => false])
      ->andWhere(['route' => 'park/default/view'])
      ->groupBy(['slug'])
      ->createCommand()
      ->queryAll();

    if(count($park_slugs)){
      foreach($park_slugs as $park){
        $park_model = Park::find()->where(['slug' => $park['slug']])->one();
        $park_model->total_view += $park['pending_view'];
        if($park_model->save()){
          FrontendRequestLog::updateAll(['is_count' => true], ['slug' => $park['slug']]);
        }
      }
    }

    //safari operator counter
    $safari_operator_slug = FrontendRequestLog::find()
      ->select(['slug', 'route', 'COUNT(*) AS pending_view'])
      ->where(['not', ['slug' => null]])
      ->andWhere(['is_count' => false])
      ->andWhere(['route' => 'operator/default/view'])
      ->groupBy(['slug'])
      ->createCommand()
      ->queryAll();

    if(count($safari_operator_slug)){
      foreach($safari_operator_slug as $operator){
        $operator_model = SafariOperator::find()->where(['slug' => $operator['slug']])->one();
        $operator_model->total_view += $operator['pending_view'];
        if($operator_model->save(false)){
          FrontendRequestLog::updateAll(['is_count' => true], ['slug' => $operator['slug']]);
        }
      }
    }

    //author counter
    $author_slug = FrontendRequestLog::find()
      ->select(['slug', 'route', 'COUNT(*) AS pending_view'])
      ->where(['not', ['slug' => null]])
      ->andWhere(['is_count' => false])
      ->andWhere(['route' => 'article/default/author'])
      ->groupBy(['slug'])
      ->createCommand()
      ->queryAll();

    if(count($author_slug)){
      foreach($author_slug as $author){ 
        $author_model = ArticleAuthor::find()->where(['slug' => $author['slug']])->one();
        $author_model->total_view += $author['pending_view'];
        if($author_model->save()){
            FrontendRequestLog::updateAll(['is_count' => true], ['slug' => $author['slug']]);
        }
      }
    }

    //shared safari counter
    $shared_safari = FrontendRequestLog::find()
      ->select(['slug', 'route', 'COUNT(*) AS pending_view'])
      ->where(['not', ['slug' => null]])
      ->andWhere(['is_count' => false])
      ->andWhere(['route' => 'sharedsafari/default/view'])
      ->groupBy(['slug'])
      ->createCommand()
      ->queryAll();

    if(count($shared_safari)){
        foreach($shared_safari as $safari){ 
            $shared_safari_model = ShareSafari::find()->where(['slug' => $safari['slug']])->one();
            $shared_safari_model->total_view += $safari['pending_view'];
            if($shared_safari_model->save()){
                FrontendRequestLog::updateAll(['is_count' => true], ['slug' => $safari['slug']]);
            }
        }
    }    
  }
}