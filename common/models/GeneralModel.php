<?php

namespace common\models;

// use common\models\blog\blogSource\BlogSource;
// use common\models\blog\blogTag\BlogTag as BlogTagBlogTag;
// use common\models\blog\category\Category;
// use common\models\blog\frequency\Frequency;

use common\models\cms\article\Article;
use common\models\cms\article\MasterArticleAuthor;
use common\models\cms\faqcategory\FaqCategory;
use common\models\cms\flagreason\Flagreason;
use common\models\cms\mastercategory\MasterTopic;
use common\models\cms\mastertag\MasterTag;
use common\models\master\country\MasterCountry;
use common\models\master\animal\MasterAnimal;
use common\models\master\airport\MasterAirport;
use common\models\master\bird\MasterBird;
use common\models\master\bonusexperience\MasterBonusExperience;
use common\models\master\city\MasterCity;
use common\models\master\email\MasterMailTemplate;
use common\models\master\faq\MasterFaq;
use common\models\master\location\MasterLocation;
use common\models\master\month\MasterMonth;
use common\models\master\operatorcategory\MasterOperatorCategory;
use common\models\master\packagefeature\MasterPackagefeature;
use common\models\master\packageinclude\MasterPackageInclude;
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
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorActivities;
use common\models\operator\SafariOperatorPark;
use common\models\operator\SafariOperatorRating;
use common\models\package\Package;
use common\models\package\PackageFaq;
use common\models\park\BirdingPark;
use common\models\park\Park;
use common\models\park\SafariPark;
use common\models\sharesafari\ShareSafariFaq;
use frontend\models\registration\BirdingOperatorRequest;
use frontend\models\registration\BirdingOperatorRequestPark;
use frontend\models\registration\SafariOperatorRequestActivities;
use frontend\models\registration\SafariOperatorRequestPark;
use common\models\trierror\FrontendRequestLog;
use Yii;
use yii\helpers\ArrayHelper;
use common\models\trierror\SitePages;
use common\models\MailLog;
use common\models\MailLogRecipients;
use common\models\master\userflag\MasterUserFlag;

class GeneralModel extends \yii\base\Model implements \common\interfaces\NewStatusInterface
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
        return ['1' => 'Active', '2' => 'Deactivate'];
    }

    /**
     * Get Status Active/Inactive Options List
     *
     * @return void
     */
    public static function commentstatusoption()
    {
        return [1 => 'Approved', 2 => 'Reject', 3 => 'Pending'];
    }

    /**
     * Get Status Active/Inactive Options List
     *
     * @return void
     */
    public static function recentstatusoption()
    {
        return ['1' => 'Active', '2' => 'Deactivate', '-1' => 'Deleted'];
    }


    /**
     * Get Status Active/Inactive Options List
     *
     * @return void
     */
    public static function approvaloption()
    {
        return [1 => 'Approved', 0 => 'Disapprove'];
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


    public static function bloguserstatusoption()
    {
        return [1 => 'Publish', 0 => 'Unpublish', -1 => 'Delete'];
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

    public static function rolesforform()
    {
        if (Yii::$app->user->identity && Yii::$app->user->identity->is_adminstrator) {
            return [
                1 => 'Administrator',
                2 => 'Admin',
                // 3 => 'Safari Operator',
                // 4 => 'Operator',  /**Operator Access used into both tables and this things is not propely handled to use operator role here */
                5 => 'Cms Manager',
                6 => 'Resort Manager',
                7 => 'Report Manager',
                8 => 'Community Manager',
            ];
        } else
        if (Yii::$app->user->identity && Yii::$app->user->identity->is_admin) {
            return [
                2 => 'Admin',
                // 3 => 'Safari Operator',
                // 4 => 'Operator',
                5 => 'Cms Manager',
                6 => 'Resort Manager',
            ];
        }
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
            7 => 'Blog Listing',
            8 => 'Blog Detail',
            9 => 'Term & Condition',
            10 => 'Accomodation',
            11 => 'Package List',
            12 => 'Package View',
        ];
    }

    public static function messagetype()
    {
        return [
            1 => 'Flash Message',
            2 => 'Heading',
            3 => 'Text',
        ];
    }

    public static function parktype()
    {
        return [
            1 => 'Safari',
            2 => 'Birding',
        ];
    }

    public static function rating()
    {
        return [
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
        ];
    }


    public static function operatorcredibility()
    {
        return [
            // 1 => 'Registered Company',
            // 2 => 'Has a Website',
            3 => 'Offers Other Wildlife Activities',
            4 => 'Has Cancellation Policy',
            // 5 => 'Wildlife Photographer',
            6 => 'Wildlife Influencer',
        ];
    }


    public static function packagedayoption()
    {
        return [
            1 => '1 day 0 night',
            2 => '2 day 1 night',
            3 => '3 day 2 night',
            4 => '4 day 3 night',
            5 => '5 day 4 night',
            6 => '6 day 5 night',
            7 => '7 day 6 night',
            8 => '8 day 7 night',
            9 => '9 day 8 night',
            10 => '10 day 9 night',
            11 => '11 day 10 night',
            12 => '12 day 11 night',
            13 => '13 day 12 night',
            14 => '14 day 13 night',
            15 => '15 day 14 night',
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
    public static function users()
    {
        return ArrayHelper::map(User::find()->where(['status' => 10])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
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
        return ArrayHelper::map(MasterVehicle::find()->where(['status' => self::STATUS_ACTIVE])
            // ->orderBy(['vehicle_name' => SORT_ASC])
            ->all(), 'id', 'vehicle_name');
    }

    public static function rareanimaloption()
    {
        return ArrayHelper::map(MasterAnimal::find()->where(['status' => self::STATUS_ACTIVE])->andWhere(['animal_type' => MasterAnimal::RARE_ANIMAL_TYPE])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }

    public static function animaloption()
    {
        return ArrayHelper::map(MasterAnimal::find()->where(['status' => self::STATUS_ACTIVE])->andWhere(['animal_type' => MasterAnimal::USUAL_ANIMAL_TYPE])->orWhere(
            ['is_searchable' => 1]
        )->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }

    public static function animalfilteroption()
    {
        return ArrayHelper::map(MasterAnimal::find()->where(['status' => self::STATUS_ACTIVE, 'is_filter' => 1, 'animal_type' => MasterAnimal::USUAL_ANIMAL_TYPE])->orderBy(['is_filter_sequence' => SORT_ASC, 'name' => SORT_ASC])->all(), 'id', 'name');
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
        return ArrayHelper::map(MetaSafariSession::find()->where(['status' => self::STATUS_ACTIVE])
            // ->orderBy(['title' => SORT_ASC])
            ->all(), 'id', 'title');
    }


    public static function staycategoryoption()
    {
        return ArrayHelper::map(MetaStayCategory::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['id' => SORT_ASC])->all(), 'id', 'title');
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

    public static function faqcategoryoption()
    {
        return ArrayHelper::map(FaqCategory::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }



    public static function authoroption()
    {
        return ArrayHelper::map(MasterArticleAuthor::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }

    // public static function userauthoroption()
    // {
    //     return ArrayHelper::map(BlogAuthor::find()->where(['status' => self::STATUS_ACTIVE])->andWhere(['not', ['user_id' => null]])->orderBy(['author_name' => SORT_ASC])->all(), 'id', 'author_name');
    // }
    // public static function sourceoption()
    // {
    //     return ArrayHelper::map(BlogSource::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['blog_source' => SORT_ASC])->all(), 'id', 'blog_source');
    // }
    // public static function frequencyoption()
    // {
    //     return ArrayHelper::map(Frequency::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['frequency' => SORT_ASC])->all(), 'id', 'frequency');
    // }
    // public static function categoryoption()
    // {
    //     return ArrayHelper::map(Category::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['category' => SORT_ASC])->all(), 'id', 'category');
    // }

    public static function birdingparkoption()
    {
        $query = BirdingPark::find()
            ->where(['status' => BirdingPark::STATUS_ACTIVE])
            ->select(['*', 'space_count' => 'CHAR_LENGTH(title) - CHAR_LENGTH(LTRIM(title))'])
            ->orderBy(['space_count' => SORT_ASC, 'title' => SORT_ASC]);

        // Get all the models
        $parks = $query->all();

        // Use ArrayHelper::map to create the key-value pairs
        $result = ArrayHelper::map($parks, 'id', 'title');
        return $result;

        // return ArrayHelper::map(Park::find()->where(['status' => self::STATUS_ACTIVE, 'park_type_id' => 2])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }
    public static function safariparkoption($column = 'id')
    {

        $query = SafariPark::find()
            ->where(['status' => SafariPark::STATUS_ACTIVE])
            ->select(['*', 'space_count' => 'CHAR_LENGTH(title) - CHAR_LENGTH(LTRIM(title))'])
            ->orderBy(['space_count' => SORT_ASC, 'title' => SORT_ASC]);

        // Get all the models
        $parks = $query->all();

        // Use ArrayHelper::map to create the key-value pairs
        $result = ArrayHelper::map($parks, $column, 'title');
        return $result;
        // return ArrayHelper::map(Park::find()->where(['status' => self::STATUS_ACTIVE, 'park_type_id' => 1])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function safariparkoperatoroption()
    {
        return ArrayHelper::map(SafariOperator::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['register_comapany_name' => SORT_ASC])->all(), 'id', 'register_comapany_name');
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
        return ArrayHelper::map(MasterLocation::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['sequence' => SORT_ASC])->all(), 'id', 'title');
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
        return ArrayHelper::map(MasterSuggestionCategory::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['sequence' => SORT_ASC, 'title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function birdingoperatorcategory()
    {
        return ArrayHelper::map(MasterOperatorCategory::find()->where(['status' => self::STATUS_ACTIVE, 'type_id' => 2])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function packageoption()
    {
        return ArrayHelper::map(MetaPackageRange::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['id' => SORT_ASC])->all(), 'id', 'title');
    }
    public static function mailtemplateoption()
    {
        return ArrayHelper::map(MasterMailTemplate::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }



    public static function getFlagreasons()
    {
        return ArrayHelper::map(Flagreason::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['id' => SORT_ASC])->all(), 'id', 'reason');
    }

    public static function operatorresquestactivties($safari_operator_request_id)
    {
        $query = SafariOperatorRequestActivities::find()->where(['status' => self::STATUS_ACTIVE, 'safari_operator_request_id' => $safari_operator_request_id]);
        return ArrayHelper::map($query->orderBy(['id' => SORT_ASC])->all(), 'wildlife_activity_id', 'wildlife_activity_id');
    }

    public static function operatoractivties($safari_operator_id)
    {
        $query = SafariOperatorActivities::find()->where(['status' => self::STATUS_ACTIVE, 'safari_operator_id' => $safari_operator_id]);
        return ArrayHelper::map($query->orderBy(['id' => SORT_ASC])->all(), 'wildlife_activity_id', 'wildlife_activity_id');
    }

    public static function operatorresquestpark($safari_operator_request_id)
    {
        $query = SafariOperatorRequestPark::find()->where(['status' => self::STATUS_ACTIVE, 'safari_operator_request_id' => $safari_operator_request_id]);
        return ArrayHelper::map($query->orderBy(['id' => SORT_ASC])->all(), 'park_id', 'park.title');
    }

    public static function operatorpark($safari_operator_id)
    {
        $query = SafariOperatorPark::find()->where(['status' => self::STATUS_ACTIVE, 'safari_operator_id' => $safari_operator_id]);
        return ArrayHelper::map($query->orderBy(['id' => SORT_ASC])->all(), 'park_id', 'park.title');
    }

    public static function birdingoperatorresquestpark($birding_operator_request_id)
    {
        $query = BirdingOperatorRequestPark::find()->where(['status' => self::STATUS_ACTIVE, 'birding_operator_request_id' => $birding_operator_request_id]);
        return ArrayHelper::map($query->orderBy(['id' => SORT_ASC])->all(), 'park_id', 'park_id');
    }

    public static function tagoption()
    {
        return ArrayHelper::map(MasterTag::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }
    // public static function blogtagoption()
    // {
    //     return ArrayHelper::map(BlogTagBlogTag::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    // }

    public static function packagefeatureoptiontopicoption()
    {
        return ArrayHelper::map(MasterTopic::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function packagefeatureoption()
    {
        return ArrayHelper::map(MasterPackagefeature::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function packageincludeoption()
    {
        return ArrayHelper::map(MasterPackageInclude::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    // public static function blogoption()
    // {

    //     $query = Blog::find()
    //         // ->where(['status' => self::STATUS_ACTIVE])
    //         ->where("status=1 AND (user_type=3)")
    //         ->select(['*', 'space_count' => 'CHAR_LENGTH(title) - CHAR_LENGTH(LTRIM(title))'])
    //         ->orderBy(['space_count' => SORT_ASC, 'title' => SORT_ASC]);

    //     // Get all the models
    //     $parks = $query->all();

    //     // Use ArrayHelper::map to create the key-value pairs
    //     $result = ArrayHelper::map($parks, 'id', 'title');
    //     return $result;
    // }

    public static function articleoptionfeature($ids = null)
    {

        $query = Article::find()
            ->where(['status' => Article::STATUS_ACTIVE])
            ->select(['*', 'space_count' => 'CHAR_LENGTH(title) - CHAR_LENGTH(LTRIM(title))'])
            ->orderBy(['space_count' => SORT_ASC, 'title' => SORT_ASC]);

        if ($ids) {
            $query->andWhere("article.id NOT IN ($ids)");
        }
        // Get all the models
        $articles = $query->all();

        // Use ArrayHelper::map to create the key-value pairs
        $result = ArrayHelper::map($articles, 'id', 'title');
        return $result;
    }

    public static function safariParkRareExoticOption()
    {
        $query = SafariPark::find()->where(['safari_park.status' => SafariPark::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC]);

        $query->joinwith(['rareanimals' => function ($query) {
            $query->andFilterWhere(['safari_parks_animal.status' => 1]);
        }]);
        $parks = $query->all();
        $result = ArrayHelper::map($parks, 'id', 'title');
        return $result;
    }


    public static function safariAnimalRareExoticOption($ids = null)
    {
        $query = MasterAnimal::find()->select(['master_animal.id', 'master_animal.name'])->where(['master_animal.status' => MasterAnimal::STATUS_ACTIVE, 'animal_type' => MasterAnimal::RARE_ANIMAL_TYPE])->orderBy(['master_animal.name' => SORT_ASC]);
        if ($ids) {
            $query->andWhere("master_animal.id NOT IN ($ids)");
        }
        $parks = $query->asarray()->all();
        $result = ArrayHelper::map($parks, 'id', 'name');
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
            <i class="fa-solid fa-star ms-2" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star-half" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
        <?php
        } else if ($rating == 1) { ?>
            <i class="fa-solid fa-star ms-2" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
        <?php
        } else if ($rating > 1 && $rating < 2) { ?>
            <i class="fa-solid fa-star ms-2" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star-half" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
        <?php
        } else if ($rating == 2) { ?>
            <i class="fa-solid fa-star ms-2" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
        <?php
        } else if ($rating > 2 && $rating < 3) { ?>

            <i class="fa-solid fa-star ms-2" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star-half" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
        <?php
        } else if ($rating == 3) { ?>
            <i class="fa-solid fa-star ms-2" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
        <?php
        } else if ($rating > 3 && $rating < 4) { ?>
            <i class="fa-solid fa-star ms-2" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star-half" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
        <?php
        } else if ($rating == 4) { ?>
            <i class="fa-solid fa-star ms-2" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: rgb(165, 165, 165);"></i>
        <?php
        } else if ($rating > 4 && $rating < 5) { ?></span>
            <i class="fa-solid fa-star ms-2" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star-half" style="color: #F7BF39;"></i>
        <?php
        } else { ?>
            <i class="fa-solid fa-star ms-2" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: #F7BF39;"></i>
            <i class="fa-solid fa-star" style="color: #F7BF39;"></i>
        <?php
        }
    }

    public static function review_rating($rating)
    {
        if ($rating == 0) { ?>
            <i class="fa-solid fa-star ms-2" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-regular fa-star"></i>
            <i class="fa-regular fa-star"></i>
            <i class="fa-regular fa-star"></i>
            <i class="fa-regular fa-star"></i>
        <?php
        } else if ($rating < 1) { ?>
            <i class="fa-solid fa-star ms-2" style="color: #09422d;"></i>
            <i class="fa-solid fa-star-half" style="color: rgb(165, 165, 165);"></i>
            <i class="fa-regular fa-star"></i>
            <i class="fa-regular fa-star"></i>
            <i class="fa-regular fa-star"></i>

        <?php
        } else if ($rating == 1) { ?>
            <i class="fa-solid fa-star ms-2" style="color: #09422d;"></i>
            <i class="fa-regular fa-star"></i>
            <i class="fa-regular fa-star"></i>
            <i class="fa-regular fa-star"></i>
            <i class="fa-regular fa-star"></i>
        <?php
        } else if ($rating > 1 && $rating < 2) { ?>
            <i class="fa-solid fa-star ms-2" style="color: #09422d;"></i>
            <i class="fa-solid fa-star-half" style="color: #09422d;"></i>
            <i class="fa-regular fa-star"></i>
            <i class="fa-regular fa-star"></i>
            <i class="fa-regular fa-star"></i>
        <?php
        } else if ($rating == 2) { ?>
            <i class="fa-solid fa-star ms-2" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-regular fa-star"></i>
            <i class="fa-regular fa-star"></i>
            <i class="fa-regular fa-star"></i>
        <?php
        } else if ($rating > 2 && $rating < 3) { ?>

            <i class="fa-solid fa-star ms-2" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star-half" style="color: #09422d;"></i>
            <i class="fa-regular fa-star"></i>
            <i class="fa-regular fa-star"></i>
        <?php
        } else if ($rating == 3) { ?>
            <i class="fa-solid fa-star ms-2" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-regular fa-star"></i>
            <i class="fa-regular fa-star"></i>
        <?php
        } else if ($rating > 3 && $rating < 4) { ?>
            <i class="fa-solid fa-star ms-2" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star-half" style="color: #09422d;"></i>
            <i class="fa-regular fa-star"></i>
        <?php
        } else if ($rating == 4) { ?>
            <i class="fa-solid fa-star ms-2" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-solid fa-star" style="color: #09422d;"></i>
            <i class="fa-regular fa-star"></i>
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


    /**
     * Remove Leading Character Default 0 remove from left side
     */
    public static function removeLeadingChar($value, $char = '0')
    {
        return ltrim($value, $char);
    }


    public static function safarirating()
    {
        return ArrayHelper::map(SafariOperatorRating::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['rating' => SORT_ASC])->all(), 'id', 'review');
    }

    public static function estimatedpriceoption()
    {
        $return = [
            '1' => '< 5000',
            '2' => '5000 - 10000',
            '3' => '10000 - 15000...',
        ];
        return $return;
    }

    public static function noofsafarioption()
    {
        $return = [
            '1' => '1',
            '2' => '3-5',
            '3' => '5-8',
            '4' => '8+',
        ];
        return $return;
    }

    public static function agendaoption()
    {
        $return = [
            '1' => 'Photography',
            // '2' => 'Vlogging',
            '3' => 'Safari Experience'
        ];
        return $return;
    }

    public static function hostoption()
    {
        // $return = [
        //     '1' => 'Individual',
        //     '2' => 'Wildlife Photographer',
        //     '3' => 'Wildlife Influencer',
        //     '4' => 'Safari Tour Operator'
        // ];
        $return = [1 => 'Individual', 2 => 'Wildlife Influencer', 3 => 'Safari Operator'];

        return $return;
    }

    public static function budgetoption()
    {
        $return = [
            '1' => 'Premium',
            '2' => 'Standard',
            '3' => 'Economical',
            '4' => 'Not Included',

        ];
        return $return;
    }

    public static function relevantoption()
    {
        $return = [
            '1' => 'Created Recently',
            '2' => 'Less Safaris',
            '3' => 'More Safaris',
            '4' => 'Cheapest',


        ];
        return $return;
    }


    public static function topicoption()
    {
        return ArrayHelper::map(MasterTopic::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function packagelist()
    {
        return ArrayHelper::map(Package::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['package_name' => SORT_ASC])->all(), 'id', 'package_name');
    }


    public static function masterfaqoption($packageId)
    {
        // Get all active FAQs
        $faqs = MasterFaq::find()
            ->where(['status' => self::STATUS_ACTIVE])
            ->orderBy(['question' => SORT_ASC])
            ->all();

        // Get the IDs of FAQs already associated with the given package
        $existingFaqIds = PackageFaq::find()
            ->select('faq_id')
            ->where(['package_id' => $packageId, 'status' => self::STATUS_ACTIVE])
            ->column();

        // Prepare an array to store FAQs that are not yet associated with the package
        $options = [];

        foreach ($faqs as $faq) {
            // Check if the FAQ ID is not already associated with the package
            if (!in_array($faq->id, $existingFaqIds)) {
                $options[$faq->id] = $faq->question;
            }
        }

        return $options;
    }


    public static function mastersharesafarifaqoption($sharesafariId)
    {
        // Get all active FAQs
        $faqs = MasterFaq::find()
            ->where(['status' => self::STATUS_ACTIVE])
            ->orderBy(['question' => SORT_ASC])
            ->all();

        // Get the IDs of FAQs already associated with the given package
        $existingFaqIds = ShareSafariFaq::find()
            ->select('faq_id')
            ->where(['share_safari_id' => $sharesafariId, 'status' => self::STATUS_ACTIVE])
            ->column();

        // Prepare an array to store FAQs that are not yet associated with the package
        $options = [];

        foreach ($faqs as $faq) {
            // Check if the FAQ ID is not already associated with the package
            if (!in_array($faq->id, $existingFaqIds)) {
                $options[$faq->id] = $faq->question;
            }
        }

        return $options;
    }


    public static function wishlisttype()
    {
        $return = [
            '1' => 'Safari Package',
            '2' => 'Shared Safari',
        ];
        return $return;
    }

    public static function userwishlist($item_id, $item_type_id, $item_type)
    {

        $wishlist = UserWishlist::find()->where(['user_id' => Yii::$app->user->identity->id, 'item_id' => $item_id, 'item_type_id' => $item_type_id])->one();
        if (!$wishlist) {
            $wishlist = new UserWishlist();
        }
        $wishlist->user_id = Yii::$app->user->identity->id;
        $wishlist->item_id = $item_id;
        $wishlist->item_type_id = $item_type_id;
        $wishlist->item_type = $item_type;
        $wishlist->status = 1;
        $wishlist->save(false);
        return $wishlist;
    }

    public static function getshorturl($url)
    {
        $output = "/";
        $temp = explode("/", $url);
        if (count($temp) > 3) {

            $output = array_slice($temp, 3);
            $output = "/" . implode("/", $output);
            $output = mb_strimwidth($output, 0, 40, ' ...');
        }

        return $output;
    }

    public static function getreferhistory($route_url)
    {
        $unisque_refer_url = FrontendRequestLog::find()->select(['refer_url'])->distinct(['refer_url'])->where(['route' => $route_url])->asArray()->all();
        $unisque_refer_url = FrontendRequestLog::find()
            ->select(['refer_url', 'COUNT(*) AS refer_from_count'])
            ->where(['route' => $route_url])
            ->groupBy(['refer_url'])
            ->createCommand()
            ->queryAll();

        $return = "<table class='table table-striped table-bordered table-hover'>";
        $return .= "<thead>";
        $return .= "<tr>";
        $return .= "<td scope='col'>Total</td>";
        $return .= "<td scope='col'>Total Refer from</td>";
        $return .= "</tr>";
        $return .= "</thead>";
        $return .= "<tbody>";
        $counter = 1;
        foreach ($unisque_refer_url as $row) {
            $refer_url = "Direct";
            if (!empty($row['refer_url'])) {
                $refer_url = "<a target='_blank' href='" . $row['refer_url'] . "'>" . $row['refer_url'] . "</a>";
            }
            $return .= "<tr>";
            $return .= "<td>" . $row['refer_from_count'] . "</td>";
            $return .= "<td>" . $refer_url . "</td>";
            $return .= "</tr>";
            $counter++;
        }
        $return .= "</tbody>";
        $return .= "</table>";
        return $return;
    }

    public static function privacyoptions()
    {
        $return = [
            '1' => 'Public',
            '2' => 'Only me',
            '3' => 'My Follower',
        ];
        return $return;
    }

    public static function sharesafarioptions()
    {
        $return = [
            '1' => 'Active',
            '0' => 'Inactive',
            '2' => 'Seat Full',
        ];
        return $return;
    }

    public static function getsitepagessubcategory($category_name)
    {
        $return = [];
        $sub_category = SitePages::find()->select('sub_category')->distinct('sub_category')->where(['category' => $category_name])->all();
        foreach ($sub_category as $sub) {
            $return[$sub->sub_category] = ucwords($sub->sub_category);
        }

        return $return;
    }
    public static function tourusers()
    {

        return ArrayHelper::map(User::find()->where(['status' => 10, 'is_safari_operator' => 1])->andWhere("id NOT IN (SELECT user_id from safari_operator WHERE user_id IS NOT NULL)")
            // ->andWhere(['<>', 'is_adminstrator', 1])->andWhere(['<>', 'is_admin', 1])

            ->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
    }


    public static function experiencesafariparkoption($user_id)
    {

        $query = SafariPark::find()
            ->where(['safari_park.status' => SafariPark::STATUS_ACTIVE])
            ->select(['*', 'space_count' => 'CHAR_LENGTH(title) - CHAR_LENGTH(LTRIM(title))'])
            ->orderBy(['space_count' => SORT_ASC, 'title' => SORT_ASC]);

        //for show only tiger reserve
        $query->andWhere(['show_in_filter' => 1]);

        // Get all the models
        // $not_parks = $query->joinWith('experiencepark', function ($additional_query) {
        //     $additional_query->where(['<>',  'user_experience.park_id', 'safari_park.id']);
        // });

        $parks = $query->andWhere(['NOT IN', 'id', UserExperience::find()->select(['park_id'])->andWhere(['user_id' => $user_id, 'status' => 1])->column()])->all();

        $result = ArrayHelper::map($parks, 'id', 'title');
        return $result;
    }


    public static function safariparklist($column = 'id')
    {

        $query = SafariPark::find()
            ->where(['status' => SafariPark::STATUS_ACTIVE, 'show_in_filter' => 1])
            ->select(['*', 'space_count' => 'CHAR_LENGTH(title) - CHAR_LENGTH(LTRIM(title))'])
            ->orderBy(['space_count' => SORT_ASC, 'title' => SORT_ASC]);

        $parks = $query->all();
        $parkoption = ArrayHelper::map($parks, $column, 'title');

        return $parkoption;
    }

    public static function sharedsafaritype()
    {
        $return = [1 => 'Shared Safari', 2 => 'Fixed Departure'];
        return $return;
    }

    public static function frontendbannertype()
    {
        return [
            '1' => 'Package Banner',
            '2' => 'Shared Safari Banner'
        ];
    }
    public static function userstatusoption()
    {
        return [
            '1' => 'Published',
            '0' => 'UnPublished',
        ];
    }

    public static function userstatusoptionwithdelete()
    {
        return [
            '1' => 'Published',
            '0' => 'UnPublished',
            '-1' => 'Delete',
        ];
    }

    public static function sendmailfromlog($mail_log_id)
    {
        $log = MailLog::find()->where(['status' => 2])->andWhere(['id' => $mail_log_id])->one();
        if ($log) {
            $cc = [];
            $bcc = [];
            foreach ($log->ccrecipients as $c) {
                $cc[] = $c->recipient;
            }

            foreach ($log->bccrecipients as $b) {
                $bcc[] = $b->recipient;
            }

            if ($log->mail_template_id) {
                $template = MasterMailTemplate::find()->where(['id' => $log->mail_template_id, 'status' => 1])->limit(1)->one();
                if ($template && Yii::$app->params['can_email_sent'] == true) {
                    $mailer =  \Yii::$app->mailer;
                    try {
                        $message = $mailer->compose($template->path, json_decode($log->params, true))
                            // ->setFrom($log->mail_from)
                            ->setFrom(['no-reply@walkintothewild.in' => 'Walk Into The Wild'])
                            ->setTo($log->torecipient->recipient)
                            ->setBcc($bcc)
                            ->setCc($cc)
                            ->setSubject($log->subject)
                            ->send();
                    } catch (Exception $e) {
                        echo 'Message: ' . $e->getMessage();
                        die('here is some errors');
                    }

                    if ($message) {
                        $m = MailLog::find()->where(['id' => $log->id])->one();

                        $id = $mailer->getSentMessage()->getMessageId();
                        $m->aws_message_id = $id;
                        $m->try_send_count = $m->try_send_count + 1;
                        $m->status = true;
                        $m->mail_send_time = date('Y-m-d H:i:s');
                        $m->save(false);
                        MailLogRecipients::updateAll([
                            'aws_message_id' => $id,
                        ], ['mail_log_id' => $log->id]);
                    }
                }
            }
        }

        return true;
    }

    /**
     * Get Status Active/Inactive Options List
     *
     * @return void
     */
    public static function newstatusoption()
    {
        return [self::STATUS_ACTIVE => "Active", self::STATUS_SUSPEND => "Inactive"];
    }

    public static function newrecentstatusoption()
    {
        return [self::STATUS_ACTIVE => 'Active', self::STATUS_SUSPEND => 'Inactive', self::STATUS_DELETE => 'Deleted'];
    }

    public static function userflagedoption()
    {
        return ArrayHelper::map(MasterUserFlag::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['user_flag' => SORT_ASC])->all(), 'id', 'user_flag');
    }

    // public static function commentconversion($comment)
    // {
    //     $exclamation = '<i class="fa-solid fa-triangle-exclamation" style="color: #FFD43B; cursor: pointer;" data-bs-toggle="tooltip" title="Phone numbers are hidden to protect privacy. Please message directly."></i>';
    //     if (preg_match('/\b\d{10}\b/', $comment)) {
    //         $comment = preg_replace('/\b(\d{5})\d{5}\b/', '$1xxxxx ' . $exclamation, $comment);
    //     } else if (preg_match('/\b(\d{5}) (\d{5})\b/', $comment)) {
    //         $comment = preg_replace('/\b(\d{5}) (\d{5})\b/', '$1 xxxxx ' . $exclamation, $comment);
    //     } else if (preg_match('/\b(\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1})\b/', $comment)) {
    //         $comment = preg_replace('/\b(\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1})\b/', '$1 $1 $1 $1 $1 x x x x x ' . $exclamation, $comment);
    //     } else if (preg_match('/\b(\d{2}) (\d{5}) (\d{5})\b/', $comment)) {
    //         $comment = preg_replace('/\b(\d{2}) (\d{5}) (\d{5})\b/', 'xx $1 xxxxx ' . $exclamation, $comment);
    //     } else if (preg_match('/\b(\d{2}) (\d{10})\b/', $comment)) {
    //         $comment = preg_replace('/\b(\d{2}) (\d{5})(\d{5})\b/', 'xx $1xxxxx ' . $exclamation, $comment);
    //     } else if (preg_match('/\b(\d{3}) (\d{1})(\d{1})(\d{1}) (\d{4})\b/', $comment)) {
    //         $comment = preg_replace('/\b(\d{3}) (\d{1})(\d{1})(\d{1}) (\d{4})\b/', '$1 $2$3x xxxx ' . $exclamation, $comment);
    //     } else if (preg_match('/\b(\d{3})(\d{1})(\d{1})(\d{1}) (\d{4})\b/', $comment)) {
    //         $comment = preg_replace('/\b(\d{3})(\d{1})(\d{1})(\d{1}) (\d{4})\b/', '$1$2$3x xxxx' . $exclamation, $comment);
    //     }
    //     return $comment;
    // }

    public static function commentConversion($comment)
    {
        $exclamation = '<i class="fa-solid fa-triangle-exclamation" style="color: #FFD43B; cursor: pointer;" data-bs-toggle="tooltip" title="Phone numbers are hidden to protect privacy. Please message directly."></i>';

        $patterns = [
            '/\b(\d{5})\d{5}\b/' => '$1xxxxx ' . $exclamation,
            '/\b(\d{5}) (\d{5})\b/' => '$1 xxxxx ' . $exclamation,
            '/\b(\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1})\b/' =>
            '$1 $1 $1 $1 $1 x x x x x ' . $exclamation,
            '/\b(\d{2}) (\d{5}) (\d{5})\b/' => 'xx $1 xxxxx ' . $exclamation,
            '/\b(\d{2}) (\d{10})\b/' => 'xx $1xxxxx ' . $exclamation,
            '/\b(\d{3}) (\d{1})(\d{1})(\d{1}) (\d{4})\b/' => '$1 $2$3x xxxx ' . $exclamation,
            '/\b(\d{3})(\d{1})(\d{1})(\d{1}) (\d{4})\b/' => '$1$2$3x xxxx' . $exclamation,
            '/\b(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})\b/'
            =>
            '$1 $2 $3 $4 $5 x x x x x ' . $exclamation,
        ];

        foreach ($patterns as $pattern => $replacement) {
            if (preg_match($pattern, $comment)) {
                $comment = preg_replace($pattern, $replacement, $comment);
                break;
            }
        }

        return $comment;
    }
}
