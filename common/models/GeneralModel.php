<?php

namespace common\models;

use common\models\cms\article\Article;
use common\models\cms\article\ArticleAuthor;
use common\models\cms\article\ArticleTag;
use common\models\cms\article\MasterArticleTag;
use common\models\cms\article\MasterArticleTopic;
use common\models\cms\faqcategory\Faq;
use common\models\master\country\MasterCountry;
use common\models\master\animal\MasterAnimal;
use common\models\master\airport\MasterAirport;
use common\models\master\bird\MasterBird;
use common\models\master\bonusexperience\MasterBonusExperience;
use common\models\master\city\MasterCity;
use common\models\master\email\MasterMailTemplate;
use common\models\master\location\MasterLocation;
use common\models\master\month\MasterMonth;
use common\models\master\operatorcategory\MasterOperatorCategory;
use common\models\master\railwaystation\MasterRailwayStation;
use common\models\master\state\MasterState;
use common\models\master\suggetioncategory\MasterSuggestionCategory;
use common\models\master\vehicle\MasterVehicle;
use common\models\meta\MetaAccommodation;
use common\models\meta\MetaAnimalType;
use common\models\meta\MetaBirdType;
use common\models\meta\MetaLocation;
use common\models\meta\MetaOperatorCategory;
use common\models\meta\MetaOtherWildlifeActivities;
use common\models\meta\MetaPackageRange;
use common\models\meta\MetaSafariSession;
use common\models\meta\MetaStayCategory;
use common\models\meta\MetaTermConditionType;
use common\models\meta\MetaZoneType;
use common\models\operator\SafariOperatorPark;
use common\models\park\BirdingPark;
use common\models\park\Park;
use common\models\park\SafariPark;
use frontend\models\registration\BirdingOperatorRequest;
use frontend\models\registration\BirdingOperatorRequestPark;
use frontend\models\registration\SafariOperatorRequestActivities;
use frontend\models\registration\SafariOperatorRequestPark;
use Yii;
use yii\helpers\ArrayHelper;

class GeneralModel extends \yii\base\Model implements \common\interfaces\StatusInterface
{

    const ORDER_BOOKING_TYPE = 'SR';

    public static function DateFormatForDb($date)
    {

        $dbDateFormat = \Yii::$app->formatter->asDatetime($date, "php:Y-m-d");
        return $dbDateFormat;
    }
    public static function DateFormatForView($date)
    {

        $viewDateFormat = \Yii::$app->formatter->asDatetime($date, "php:d-m-Y");
        return $viewDateFormat;
    }

    /**
     * Get Status Active/Inactive Options List
     *
     * @return void
     */
    public static function statusoption()
    {
        return [self::STATUS_ACTIVE => 'Active', self::STATUS_SUSPEND => 'Suspend'];
    }


    /**
     * Get Status Active/Inactive Options List
     *
     * @return void
     */
    public static function recentstatusoption()
    {
        return [self::STATUS_ACTIVE => 'Active', self::STATUS_SUSPEND => 'Suspend', self::STATUS_DELETE => 'Deleted'];
    }

    /**
     * Get Status Active/Inactive Options List
     *
     * @return void
     */
    public static function sortingoption()
    {
        return [3 => 'A To Z', 4 => 'Z To A'];
    }

    /**
     * Get Yes No Option List
     *
     * @return void
     */
    public static function yesnooption()
    {
        return [1 => 'Yes', 0 => 'No'];
    }

    /**
     * Day short Name
     *
     * @return array
     */
    public static function dayshortname()
    {
        return [
            1 => 'mon',
            2 => 'tue',
            3 => 'wed',
            4 => 'thu',
            5 => 'fri',
            6 => 'sat',
            7 => 'sun',
        ];
    }

    /**
     * Day Name
     *
     * @return array
     */
    public static function dayname()
    {
        return [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday',
        ];
    }



    public static function roles()
    {
        return [
            1 => 'Administrator',
            2 => 'Admin',
            3 => 'Safari Operator',
            4 => 'Operator',
            5 => 'Cms Manager',
            6 => 'Resort Manager',
            7 => 'Report Manager',
        ];
    }

    public static function pages()
    {
        return [
            1 => 'Home',
            2 => 'Park List',
            3 => 'Park View',
            4 => 'Operator View',
            5 => 'Share Safari',
            6 => 'Join Safari',
            7 => 'Article Listing',
            8 => 'Article Detail',
            9 => 'Term & Condition',
            10 => 'Accomodation',
        ];
    }



    public static function parktype()
    {
        return [
            1 => 'Safari',
            2 => 'Birding',
        ];
    }


    public static function numberformat($num)
    {
        if ($num) {
            $len = strlen($num);
            $m = '';
            $num = strrev($num);
            for ($i = 0; $i < $len; $i++) {
                if (($i == 3 || ($i > 3 && ($i - 1) % 2 == 0)) && $i != $len) {
                    $m .= ',';
                }
                $m .= $num[$i];
            }
            return strrev($m);
        }
        return $num;
    }

    /**
     * Get Panel Option List
     *
     * @return void
     */
    public static function paneloption()
    {
        return [1 => 'Backend', 2 => 'Frontend'];
    }

    public static function stateoption()
    {
        return ArrayHelper::map(MasterState::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['state_name' => SORT_ASC])->all(), 'id', 'state_name');
    }

    public static function countryoption()
    {
        return ArrayHelper::map(MasterCountry::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['country_name' => SORT_ASC])->all(), 'id', 'country_name');
    }



    public static function vehicleoption()
    {
        return ArrayHelper::map(MasterVehicle::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['vehicle_name' => SORT_ASC])->all(), 'id', 'vehicle_name');
    }

    public static function animaloption()
    {
        return ArrayHelper::map(MasterAnimal::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }

    public static function animalfilteroption()
    {
        return ArrayHelper::map(MasterAnimal::find()->where(['status' => self::STATUS_ACTIVE, 'is_filter' => 1])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }

    public static function birdoption()
    {
        return ArrayHelper::map(MasterBird::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }

    public static function animaltypeoption()
    {
        return ArrayHelper::map(MetaAnimalType::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function birdtypeoption()
    {
        return ArrayHelper::map(MetaBirdType::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function locationoption()
    {
        return ArrayHelper::map(MetaLocation::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function safarisessionoption()
    {
        return ArrayHelper::map(MetaSafariSession::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }


    public static function staycategoryoption()
    {
        return ArrayHelper::map(MetaStayCategory::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function accomodationoption()
    {
        return ArrayHelper::map(MetaAccommodation::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }


    public static function zonetypeoption()
    {
        return ArrayHelper::map(MetaZoneType::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }

    public static function monthoption()
    {
        return ArrayHelper::map(MasterMonth::find()->orderBy(['month' => SORT_ASC])->all(), 'month', 'month_name');
    }


    public static function railwaystationoption()
    {
        return ArrayHelper::map(MasterRailwayStation::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function airportoption()
    {
        return ArrayHelper::map(MasterAirport::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }

    public static function bonusexperienceoption()
    {
        return ArrayHelper::map(MasterBonusExperience::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function getAllState($countryId)
    {
        return ArrayHelper::map(MasterState::find()->where(['country_id' => $countryId, 'status' => self::STATUS_ACTIVE])->orderBy(['state_name' => SORT_ASC])->all(), 'id', 'state_name');
    }

    public static function getAllCity($master_state_id)
    {
        return ArrayHelper::map(MasterCity::find()->where(['state_id' => $master_state_id, 'status' => self::STATUS_ACTIVE])->orderBy(['city_name' => SORT_ASC])->all(), 'id', 'city_name');
    }


    public static function parkoption()
    {
        return ArrayHelper::map(Park::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function faqoption()
    {
        return ArrayHelper::map(Faq::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }



    public static function authoroption()
    {
        return ArrayHelper::map(ArticleAuthor::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['author_name' => SORT_ASC])->all(), 'id', 'author_name');
    }


    public static function birdingparkoption()
    {
        $query = BirdingPark::find()
            ->where(['status' => Park::STATUS_ACTIVE])
            ->select(['*', 'space_count' => 'CHAR_LENGTH(title) - CHAR_LENGTH(LTRIM(title))'])
            ->orderBy(['space_count' => SORT_ASC, 'title' => SORT_ASC]);

        // Get all the models
        $parks = $query->all();

        // Use ArrayHelper::map to create the key-value pairs
        $result = ArrayHelper::map($parks, 'id', 'title');
        return $result;

        // return ArrayHelper::map(Park::find()->where(['status' => self::STATUS_ACTIVE, 'park_type_id' => 2])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }
    public static function safariparkoption()
    {

        $query = SafariPark::find()
            ->where(['status' => Park::STATUS_ACTIVE])
            ->select(['*', 'space_count' => 'CHAR_LENGTH(title) - CHAR_LENGTH(LTRIM(title))'])
            ->orderBy(['space_count' => SORT_ASC, 'title' => SORT_ASC]);

        // Get all the models
        $parks = $query->all();

        // Use ArrayHelper::map to create the key-value pairs
        $result = ArrayHelper::map($parks, 'id', 'title');
        return $result;
        // return ArrayHelper::map(Park::find()->where(['status' => self::STATUS_ACTIVE, 'park_type_id' => 1])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function getAllRailwayStation()
    {
        return ArrayHelper::map(MasterRailwayStation::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function getAllAirport()
    {
        return ArrayHelper::map(MasterAirport::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }

    public static function getAllLocation()
    {
        return ArrayHelper::map(MasterLocation::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function wildlifeactivities()
    {
        return ArrayHelper::map(MetaOtherWildlifeActivities::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function operatorcategory()
    {
        return ArrayHelper::map(MasterOperatorCategory::find()->where(['status' => self::STATUS_ACTIVE, 'type_id' => 1])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }


    public static function suggestioncategory()
    {
        return ArrayHelper::map(MasterSuggestionCategory::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function birdingoperatorcategory()
    {
        return ArrayHelper::map(MasterOperatorCategory::find()->where(['status' => self::STATUS_ACTIVE, 'type_id' => 2])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function packageoption()
    {
        return ArrayHelper::map(MetaPackageRange::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }
    public static function mailtemplateoption()
    {
        return ArrayHelper::map(MasterMailTemplate::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }


    public static function operatorresquestactivties($safari_operator_request_id)
    {
        $query = SafariOperatorRequestActivities::find()->where(['status' => self::STATUS_ACTIVE, 'safari_operator_request_id' => $safari_operator_request_id]);
        return ArrayHelper::map($query->orderBy(['id' => SORT_ASC])->all(), 'wildlife_activity_id', 'wildlife_activity_id');
    }

    public static function operatorresquestpark($safari_operator_request_id)
    {
        $query = SafariOperatorRequestPark::find()->where(['status' => self::STATUS_ACTIVE, 'safari_operator_request_id' => $safari_operator_request_id]);
        return ArrayHelper::map($query->orderBy(['id' => SORT_ASC])->all(), 'park_id', 'park_id');
    }

    public static function birdingoperatorresquestpark($birding_operator_request_id)
    {
        $query = BirdingOperatorRequestPark::find()->where(['status' => self::STATUS_ACTIVE, 'birding_operator_request_id' => $birding_operator_request_id]);
        return ArrayHelper::map($query->orderBy(['id' => SORT_ASC])->all(), 'park_id', 'park_id');
    }

    public static function tagoption()
    {
        return ArrayHelper::map(MasterArticleTag::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function topicoption()
    {
        return ArrayHelper::map(MasterArticleTopic::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function articleoption()
    {

        $query = Article::find()
            ->where(['status' => self::STATUS_ACTIVE])
            ->select(['*', 'space_count' => 'CHAR_LENGTH(title) - CHAR_LENGTH(LTRIM(title))'])
            ->orderBy(['space_count' => SORT_ASC, 'title' => SORT_ASC]);

        // Get all the models
        $parks = $query->all();

        // Use ArrayHelper::map to create the key-value pairs
        $result = ArrayHelper::map($parks, 'id', 'title');
        return $result;
    }

    public static function safariParkRareExoticOption()
    {
        $query = SafariPark::find()->where(['safari_park.status' => Park::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC]);

        $query->joinwith(['animals' => function ($query) {
            $query->andFilterWhere(['safari_parks_animal.animal_type_id' => 2]);
        }]);
        $parks = $query->all();
        $result = ArrayHelper::map($parks, 'id', 'title');
        return $result;
    }




    public static function ratiing_views($rating)
    {
        if ($rating == 0) { ?>
            <i class="fa-solid fa-star ms-2" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
        <?php
        } else if ($rating < 1) { ?>
            <i class="fa-solid fa-star ms-2" style="color: #09422d;"></i>
            <i class="fa-solid fa-star-half" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
        <?php
        } else if ($rating == 1) { ?>
            <i class="fa-solid fa-star ms-2" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
        <?php
        } else if ($rating > 1 && $rating < 2) { ?>
            <i class="fa-solid fa-star ms-2" style="color: #09422d;"></i>
            <i class="fa-solid fa-star-half" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
        <?php
        } else if ($rating == 2) { ?>
            <i class="fa-solid fa-star ms-2" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
        <?php
        } else if ($rating > 2 && $rating < 3) { ?>

            <i class="fa-solid fa-star ms-2" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star-half" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
        <?php
        } else if ($rating == 3) { ?>
            <i class="fa-solid fa-star ms-2" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
        <?php
        } else if ($rating > 3 && $rating < 4) { ?>
            <i class="fa-solid fa-star ms-2" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star-half" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
        <?php
        } else if ($rating == 4) { ?>
            <i class="fa-solid fa-star ms-2" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
        <?php
        } else if ($rating > 4 && $rating < 5) { ?></span>
            <i class="fa-solid fa-star ms-2" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star-half" style="color: #09422d;"></i>
        <?php
        } else { ?>
            <i class="fa-solid fa-star ms-2" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
<?php
        }
    }


    public static function get_substring($text, $word_limit = 100)
    {
        // Split the text into an array of words
        $words = explode(' ', $text);

        // Slice the array to get the first 70 words
        $limited_words = array_slice($words, 0, $word_limit);

        // Join the words back into a single string
        $substring = implode(' ', $limited_words);

        return $substring;
    }

    public static function operatorsafariparkoption($operator_id)
    {
        $operator_safari_park = [];
        $operatorsafariparkData = SafariOperatorPark::find()->where(['safari_operator_id' => $operator_id, 'status' => 1])->all();
        if (count($operatorsafariparkData) >= 1) {

            foreach ($operatorsafariparkData as $operatorsafaripark) {
                $operator_safari_park[] = $operatorsafaripark->park_id;
            }
        }
        $safariparkList =  SafariPark::find()->where(['in', 'id', $operator_safari_park]);
        return ArrayHelper::map($safariparkList->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function termconditionoption()
    {
        return ArrayHelper::map(MetaTermConditionType::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }
}
