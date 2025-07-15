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
use common\models\package\PackageVersion;
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
use common\models\master\notification\MasterNotificationTemplate;
use common\models\master\smstemplate\MasterSmsTemplate;
use common\models\master\userflag\MasterUserFlag;
use common\models\partnergallery\PartnerGallery;
use DOMDocument;
use DOMXPath;
use Exception;

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
        $arr = [
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

        asort($arr);
        return $arr;
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
        return ArrayHelper::map(MetaStayCategory::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['sequence' => SORT_ASC])->all(), 'id', 'title');
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

    public static function notificationtemplateoption()
    {
        return ArrayHelper::map(MasterNotificationTemplate::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['type' => SORT_ASC])->all(), 'id', 'type');
    }

    public static function smstemplateoption()
    {
        return ArrayHelper::map(MasterSmsTemplate::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
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

    public static function sharesafarioptionswithdelete()
    {
        $return = [
            '3' => 'Live',
            '1' => 'Active',
            '0' => 'Inactive By User',
            '2' => 'Seat Full',
            '-1' => 'Delete by Admin'
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

    public static function livestatusoption()
    {
        return ['1' => 'Live', '0' => 'Dead'];
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

    // public static function commentConversion($comment)
    // {
    //     $exclamation = '<i class="fa-solid fa-triangle-exclamation" style="color: #FFD43B; cursor: pointer;" data-bs-toggle="tooltip" title="Phone numbers are hidden to protect privacy. Please message directly."></i>';

    //     $patterns = [
    //         '/\b(\d{5})\d{5}\b/' => '$1xxxxx ' . $exclamation,
    //         '/\b(\d{5}) (\d{5})\b/' => '$1 xxxxx ' . $exclamation,
    //         '/\b(\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1})\b/' =>
    //         '$1 $1 $1 $1 $1 x x x x x ' . $exclamation,
    //         '/\b(\d{2}) (\d{5}) (\d{5})\b/' => 'xx $1 xxxxx ' . $exclamation,
    //         '/\b(\d{2}) (\d{10})\b/' => 'xx $1xxxxx ' . $exclamation,
    //         '/\b(\d{3}) (\d{1})(\d{1})(\d{1}) (\d{4})\b/' => '$1 $2$3x xxxx ' . $exclamation,
    //         '/\b(\d{3})(\d{1})(\d{1})(\d{1}) (\d{4})\b/' => '$1$2$3x xxxx' . $exclamation,
    //         '/\b(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})\b/'
    //         =>
    //         '$1 $2 $3 $4 $5 x x x x x ' . $exclamation,
    //     ];

    //     foreach ($patterns as $pattern => $replacement) {
    //         if (preg_match($pattern, $comment)) {
    //             $comment = preg_replace($pattern, $replacement, $comment);
    //             break;
    //         }
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

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML(mb_convert_encoding($comment, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);
        foreach ($xpath->query('//text()') as $node) {
            $text = $node->nodeValue;
            foreach ($patterns as $pattern => $replacement) {
                if (preg_match($pattern, $text)) {
                    $newText = preg_replace($pattern, $replacement, $text);
                    $fragment = $dom->createDocumentFragment();
                    $fragment->appendXML($newText);
                    $node->parentNode->replaceChild($fragment, $node);
                    break;
                }
            }

            $node->nodeValue = $text;
        }

        return $dom->saveHTML();
    }

    public static function Countries()
    {
        return $countries = array(
            "Afghanistan" => "Afghanistan",
            "Albania" => "Albania",
            "Algeria" => "Algeria",
            "American" => "American Samoa",
            "Andorra" => "Andorra",
            "Angola" => "Angola",
            "Anguilla" => "Anguilla",
            "Antarctica" => "Antarctica",
            "Antigua" => "Antigua and Barbuda",
            "Argentina" => "Argentina",
            "Armenia" => "Armenia",
            "Aruba" => "Aruba",
            "Australia" => "Australia",
            "Austria" => "Austria",
            "Azerbaijan" => "Azerbaijan",
            "Bahamas" => "Bahamas",
            "Bahrain" => "Bahrain",
            "Bangladesh" => "Bangladesh",
            "Barbados" => "Barbados",
            "Belarus" => "Belarus",
            "Belgium" => "Belgium",
            "Belize" => "Belize",
            "Benin" => "Benin",
            "Bermuda" => "Bermuda",
            "Bhutan" => "Bhutan",
            "Bolivia" => "Bolivia",
            "Bosnia" => "Bosnia and Herzegowina",
            "Botswana" => "Botswana",
            "Bouvet" => "Bouvet Island",
            "Brazil" => "Brazil",
            "British" => "British Indian Ocean Territory",
            "Brunei" => "Brunei Darussalam",
            "Bulgaria" => "Bulgaria",
            "Burkina" => "Burkina Faso",
            "Burundi" => "Burundi",
            "Cambodia" => "Cambodia",
            "Cameroon" => "Cameroon",
            "Canada" => "Canada",
            "Cape" => "Cape Verde",
            "Cayman" => "Cayman Islands",
            "Central" => "Central African Republic",
            "Chad" => "Chad",
            "Chile" => "Chile",
            "China" => "China",
            "Christmas" => "Christmas Island",
            "Cocos" => "Cocos (Keeling) Islands",
            "Colombia" => "Colombia",
            "Comoros" => "Comoros",
            "Congo" => "Congo",
            "Congo" => "Congo, the Democratic Republic of the",
            "Cook" => "Cook Islands",
            "Costa" => "Costa Rica",
            "Cote" => "Cote d'Ivoire",
            "Croatia" => "Croatia (Hrvatska)",
            "Cuba" => "Cuba",
            "Cyprus" => "Cyprus",
            "Czech" => "Czech Republic",
            "Denmark" => "Denmark",
            "Djibouti" => "Djibouti",
            "Dominica" => "Dominica",
            "Dominican" => "Dominican Republic",
            "East" => "East Timor",
            "Ecuador" => "Ecuador",
            "Egypt" => "Egypt",
            "El" => "El Salvador",
            "Equatorial" => "Equatorial Guinea",
            "Eritrea" => "Eritrea",
            "Estonia" => "Estonia",
            "Ethiopia" => "Ethiopia",
            "Falkland" => "Falkland Islands (Malvinas)",
            "Faroe" => "Faroe Islands",
            "Fiji" => "Fiji",
            "Finland" => "Finland",
            "France" => "France",
            "France" => "France Metropolitan",
            "French" => "French Guiana",
            "French" => "French Polynesia",
            "French" => "French Southern Territories",
            "Gabon" => "Gabon",
            "Gambia" => "Gambia",
            "Georgia" => "Georgia",
            "Germany" => "Germany",
            "Ghana" => "Ghana",
            "Gibraltar" => "Gibraltar",
            "Greece" => "Greece",
            "Greenland" => "Greenland",
            "Grenada" => "Grenada",
            "Guadeloupe" => "Guadeloupe",
            "Guam" => "Guam",
            "Guatemala" => "Guatemala",
            "Guinea" => "Guinea",
            "Guinea" => "Guinea-Bissau",
            "Guyana" => "Guyana",
            "Haiti" => "Haiti",
            "Heard" => "Heard and Mc Donald Islands",
            "Holy" => "Holy See (Vatican City State)",
            "Honduras" => "Honduras",
            "Hong" => "Hong Kong",
            "Hungary" => "Hungary",
            "Iceland" => "Iceland",
            "India" => "India",
            "Indonesia" => "Indonesia",
            "Iran" => "Iran (Islamic Republic of)",
            "Iraq" => "Iraq",
            "Ireland" => "Ireland",
            "Israel" => "Israel",
            "Italy" => "Italy",
            "Jamaica" => "Jamaica",
            "Japan" => "Japan",
            "Jordan" => "Jordan",
            "Kazakhstan" => "Kazakhstan",
            "Kenya" => "Kenya",
            "Kiribati" => "Kiribati",
            "Korea" => "Korea, Democratic People's Republic of",
            "Korea" => "Korea, Republic of",
            "Kuwait" => "Kuwait",
            "Kyrgyzstan" => "Kyrgyzstan",
            "Lao" => "Lao, People's Democratic Republic",
            "Latvia" => "Latvia",
            "Lebanon" => "Lebanon",
            "Lesotho" => "Lesotho",
            "Liberia" => "Liberia",
            "Libyan" => "Libyan Arab Jamahiriya",
            "Liechtenstein" => "Liechtenstein",
            "Lithuania" => "Lithuania",
            "Luxembourg" => "Luxembourg",
            "Macau" => "Macau",
            "Macedonia" => "Macedonia, The Former Yugoslav Republic of",
            "Madagascar" => "Madagascar",
            "Malawi" => "Malawi",
            "Malaysia" => "Malaysia",
            "Maldives" => "Maldives",
            "Mali" => "Mali",
            "Malta" => "Malta",
            "Marshall" => "Marshall Islands",
            "Martinique" => "Martinique",
            "Mauritania" => "Mauritania",
            "Mauritius" => "Mauritius",
            "Mayotte" => "Mayotte",
            "Mexico" => "Mexico",
            "Micronesia" => "Micronesia, Federated States of",
            "Moldova" => "Moldova, Republic of",
            "Monaco" => "Monaco",
            "Mongolia" => "Mongolia",
            "Montserrat" => "Montserrat",
            "Morocco" => "Morocco",
            "Mozambique" => "Mozambique",
            "Myanmar" => "Myanmar",
            "Namibia" => "Namibia",
            "Nauru" => "Nauru",
            "Nepal" => "Nepal",
            "Netherlands" => "Netherlands",
            "Netherlands" => "Netherlands Antilles",
            "New" => "New Caledonia",
            "New" => "New Zealand",
            "Nicaragua" => "Nicaragua",
            "Niger" => "Niger",
            "Nigeria" => "Nigeria",
            "Niue" => "Niue",
            "Norfolk" => "Norfolk Island",
            "Northern" => "Northern Mariana Islands",
            "Norway" => "Norway",
            "Oman" => "Oman",
            "Pakistan" => "Pakistan",
            "Palau" => "Palau",
            "Panama" => "Panama",
            "Papua" => "Papua New Guinea",
            "Paraguay" => "Paraguay",
            "Peru" => "Peru",
            "Philippines" => "Philippines",
            "Pitcairn" => "Pitcairn",
            "Poland" => "Poland",
            "Portugal" => "Portugal",
            "Puerto" => "Puerto Rico",
            "Qatar" => "Qatar",
            "Reunion" => "Reunion",
            "Romania" => "Romania",
            "Russian" => "Russian Federation",
            "Rwanda" => "Rwanda",
            "Saint" => "Saint Kitts and Nevis",
            "Saint" => "Saint Lucia",
            "Saint" => "Saint Vincent and the Grenadines",
            "Samoa" => "Samoa",
            "San" => "San Marino",
            "Sao" => "Sao Tome and Principe",
            "Saudi" => "Saudi Arabia",
            "Senegal" => "Senegal",
            "Seychelles" => "Seychelles",
            "Sierra" => "Sierra Leone",
            "Singapore" => "Singapore",
            "Slovakia" => "Slovakia (Slovak Republic)",
            "Slovenia" => "Slovenia",
            "Solomon" => "Solomon Islands",
            "Somalia" => "Somalia",
            "South" => "South Africa",
            "South" => "South Georgia and the South Sandwich Islands",
            "Spain" => "Spain",
            "Sri" => "Sri Lanka",
            "St" => "St. Helena",
            "St" => "St. Pierre and Miquelon",
            "Sudan" => "Sudan",
            "Suriname" => "Suriname",
            "Svalbard" => "Svalbard and Jan Mayen Islands",
            "Swaziland" => "Swaziland",
            "Sweden" => "Sweden",
            "Switzerland" => "Switzerland",
            "Syrian" => "Syrian Arab Republic",
            "Taiwan" => "Taiwan, Province of China",
            "Tajikistan" => "Tajikistan",
            "Tanzania" => "Tanzania, United Republic of",
            "Thailand" => "Thailand",
            "Togo" => "Togo",
            "Tokelau" => "Tokelau",
            "Tonga" => "Tonga",
            "Trinidad" => "Trinidad and Tobago",
            "Tunisia" => "Tunisia",
            "Turkey" => "Turkey",
            "Turkmenistan" => "Turkmenistan",
            "Turks" => "Turks and Caicos Islands",
            "Tuvalu" => "Tuvalu",
            "Uganda" => "Uganda",
            "Ukraine" => "Ukraine",
            "United" => "United Arab Emirates",
            "United" => "United Kingdom",
            "United" => "United States",
            "United" => "United States Minor Outlying Islands",
            "Uruguay" => "Uruguay",
            "Uzbekistan" => "Uzbekistan",
            "Vanuatu" => "Vanuatu",
            "Venezuela" => "Venezuela",
            "Vietnam" => "Vietnam",
            "Virgin" => "Virgin Islands (British)",
            "Virgin" => "Virgin Islands (U.S.)",
            "Wallis" => "Wallis and Futuna Islands",
            "Western" => "Western Sahara",
            "Yemen" => "Yemen",
            "Yugoslavia" => "Yugoslavia",
            "Zambia" => "Zambia",
            "Zimbabwe" => "Zimbabwe"
        );
    }

    public static function extentionRemove($filename)
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $filename = preg_replace('/\.' . preg_quote($ext, '/') . '$/', '', $filename);
        return $filename;
    }

    public static function operatorsIdOrNull($user_id)
    {
        $safari_operator = SafariOperator::find()
            ->where(['user_id' => $user_id])
            ->limit(1)
            ->one();

        return $safari_operator ? $safari_operator->id : null;
    }

    public static function addparkoption($operator_id)
    {

        $operator_parks = SafariOperatorPark::find()->where(['safari_operator_id' => $operator_id, 'status' => 1])->all();
        $ids = array_column($operator_parks, 'park_id');

        $safariparkList =  SafariPark::find()->where(['not in', 'id', $ids])->andWhere(['status' => SafariPark::STATUS_ACTIVE, 'show_in_filter' => 1]);
        return ArrayHelper::map($safariparkList->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function number_format_indian($number)
    {
        $decimal = '';
        if (strpos($number, '.') !== false) {
            list($number, $decimal) = explode('.', $number);
            $decimal = '.' . $decimal;
        }
        $length = strlen($number);
        $result = '';
        if ($length > 3) {
            $result = substr($number, -3);
            $number = substr($number, 0, $length - 3);
            while (strlen($number) > 0) {
                $result = substr($number, -2) . ',' . $result;
                $number = substr($number, 0, -2);
            }
        } else {
            $result = $number;
        }
        return $result . $decimal;
    }

    public static function operatorslist()
    {
        $safari_operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE])->orderBy(['business_name' => SORT_ASC]);
        return ArrayHelper::map($safari_operator->all(), 'id', 'business_name');
    }

    public static function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    public static function packagemetastaycategory()
    {
        return ArrayHelper::map(MetaStayCategory::find()->where(['status' => self::STATUS_ACTIVE])->andWhere(['!=', 'sequence_for_package', 0])->orderBy(['sequence_for_package' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function leadSource()
    {
        return [
            1 => 'Package',
            2 => 'Park',
            3 => 'Partner'
        ];
    }

    public static function moduletype()
    {
        $module_type = [
            1 => 'Package',
            2 => 'Safari',
            3 => 'Fixed Departure',
            4 => 'User',
            5 => 'Operator',
            6 => 'Chat',
            7 => 'Comment/Review',
            8 => 'Quote',
            9 => 'Post',
            10 => 'Sighting',
        ];
        asort($module_type);
        return $module_type;
    }

    public static function formatIndianCurrency($amount)
    {
        $decimal = '';
        if (strpos($amount, '.') !== false) {
            list($amount, $decimal) = explode('.', $amount);
            $decimal = '.' . substr($decimal, 0, 2); // Keep only two decimal places
        }
        $lastThree = substr($amount, -3);
        $restUnits = substr($amount, 0, -3);
        if ($restUnits != '') {
            $lastThree = ',' . $lastThree;
        }
        $formatted = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $restUnits) . $lastThree . $decimal;
        return $formatted;
    }

    public static function PaymentgatewayOptions()
    {
        return [
            1 => 'PayU',
            2 => 'ICICI',
            3 => 'HDFC',
        ];
    }

    public static function safarisession()
    {
        $query = ArrayHelper::map(MetaSafariSession::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['id' => SORT_ASC])->all(), 'id', 'title');
        return $query;
    }

    public static function safarizone()
    {
        $query = ArrayHelper::map(MetaZoneType::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['id' => SORT_ASC])->all(), 'id', 'name');
        return $query;
    }

    public static function apicommentConversion($comment)
    {
        // $exclamation = '<i class="fa-solid fa-triangle-exclamation" style="color: #FFD43B; cursor: pointer;" data-bs-toggle="tooltip" title="Phone numbers are hidden to protect privacy. Please message directly."></i>';

        // $patterns = [
        //     '/\b(\d{5})\d{5}\b/' => '$1xxxxx ' . $exclamation,
        //     '/\b(\d{5}) (\d{5})\b/' => '$1 xxxxx ' . $exclamation,
        //     '/\b(\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1})\b/' =>
        //     '$1 $1 $1 $1 $1 x x x x x ' . $exclamation,
        //     '/\b(\d{2}) (\d{5}) (\d{5})\b/' => 'xx $1 xxxxx ' . $exclamation,
        //     '/\b(\d{2}) (\d{10})\b/' => 'xx $1xxxxx ' . $exclamation,
        //     '/\b(\d{3}) (\d{1})(\d{1})(\d{1}) (\d{4})\b/' => '$1 $2$3x xxxx ' . $exclamation,
        //     '/\b(\d{3})(\d{1})(\d{1})(\d{1}) (\d{4})\b/' => '$1$2$3x xxxx' . $exclamation,
        //     '/\b(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})\b/'
        //     =>
        //     '$1 $2 $3 $4 $5 x x x x x ' . $exclamation,
        // ];

        // foreach ($patterns as $pattern => $replacement) {
        //     if (preg_match($pattern, $comment)) {
        //         $comment = preg_replace($pattern, $replacement, $comment);
        //         break;
        //     }
        // }

        // $exclamation = '<i class="fa-solid fa-triangle-exclamation" style="color: #FFD43B; cursor: pointer;" data-bs-toggle="tooltip" title="Phone numbers are hidden to protect privacy. Please message directly."></i>';
        $exclamation = '';

        $patterns = [
            '/\b(\d{5})\d{5}\b/' => '$1xxxxx' . $exclamation,
            '/\b(\d{5}) (\d{5})\b/' => '$1 xxxxx' . $exclamation,
            '/\b(\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1}) (\d{1})\b/' =>
            '$1 $1 $1 $1 $1 x x x x x' . $exclamation,
            '/\b(\d{2}) (\d{5}) (\d{5})\b/' => 'xx $1 xxxxx' . $exclamation,
            '/\b(\d{2}) (\d{10})\b/' => 'xx $1xxxxx' . $exclamation,
            '/\b(\d{3}) (\d{1})(\d{1})(\d{1}) (\d{4})\b/' => '$1 $2$3x xxxx' . $exclamation,
            '/\b(\d{3})(\d{1})(\d{1})(\d{1}) (\d{4})\b/' => '$1$2$3x xxxx' . $exclamation,
            '/\b(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})[^\d]*(\d{1})\b/'
            =>
            '$1 $2 $3 $4 $5 x x x x x' . $exclamation,
        ];

        foreach ($patterns as $pattern => $replacement) {
            if (preg_match($pattern, $comment)) {
                $comment = preg_replace($pattern, $replacement, $comment);
                break;
            }
        }

        return $comment;
    }

    public static function strMaxlength($value, $limit = 200)
    {
        $value = strlen($value) > $limit ? (substr($value, 0, $limit) . '...') : $value;

        return $value;
    }

    public static function strMaxWord($value, $limit = 50)
    {
        // Split the string into an array of words
        $words = explode(' ', $value);

        // Check if the number of words exceeds the limit
        if (count($words) > $limit) {
            // Take only the first $limit words and append '...'
            $value = implode(' ', array_slice($words, 0, $limit)) . '...';
        }

        return $value;
    }

    public static function packageStayOption()
    {
        return ArrayHelper::map(MetaStayCategory::find()->where(['status' => 1])->orderBy(['sequence_for_package' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function mobileVerfied()
    {
        return [
            1 => 'Yes',
            0 => 'No',
        ];
    }

    public static function name_with_email($id)
    {
        $user = User::find()->where(['id' => $id])->limit(1)->one();
        return $user->name . '(' . $user->email . ')';
    }

    public static function encrypt($data)
    {
        $key = Yii::$app->params['encryption_key'];
        $cipher = "aes-256-cbc";

        // Ensure the encryption key is valid
        if (empty($key) || strlen($key) !== 32) {
            throw new Exception("Invalid encryption key. Ensure it is 32 characters long.");
        }

        // Hardcoded IV (must be 16 bytes for aes-256-cbc)
        $iv = '1234567890123456'; // Example IV (16 characters)

        // Encrypt the data
        $encrypted_data = openssl_encrypt($data, $cipher, $key, 0, $iv);

        if ($encrypted_data === false) {
            throw new Exception("Encryption failed.");
        }

        // Encode the encrypted data and IV separately
        $encrypted_string = base64_encode($encrypted_data) . '::' . base64_encode($iv);

        // Replace '/' with '_' in the final encrypted string for safe transmission
        $encrypted_string = str_replace('/', '_', $encrypted_string);

        return $encrypted_string;
    }

    public static function decrypt($data)
    {
        $key = Yii::$app->params['encryption_key'];
        $cipher = "aes-256-cbc";

        // Replace '_' back to '/' before decoding
        $data = str_replace('_', '/', $data);

        // Validate the format of $data
        if (strpos($data, '::') === false) {
            Yii::error("Decrypt method received invalid data format: " . print_r($data, true), __METHOD__);
            throw new Exception("Invalid encrypted data format. Expected '::' delimiter.");
        }

        // Split the encrypted data and IV
        list($encrypted_data, $encoded_iv) = explode('::', $data, 2);

        // Decode the encrypted data and IV
        $encrypted_data = base64_decode($encrypted_data);
        $iv = base64_decode($encoded_iv);

        // Ensure the IV matches the hardcoded value
        $hardcoded_iv = '1234567890123456'; // Same as in the encrypt method
        if ($iv !== $hardcoded_iv) {
            throw new Exception("Invalid IV value.");
        }

        // Decrypt the data
        $decrypted_data = openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);
        if ($decrypted_data === false) {
            Yii::error("Decryption failed for data: " . print_r($data, true), __METHOD__);
            throw new Exception("Decryption failed");
        }

        return $decrypted_data;
    }

    public static function maskContactInfoInString(string $text): string
    {

        // Define a mapping for number words to digits
        $numberWordMap = [
            'zero'  => '0',
            'one'   => '1',
            'two'   => '2',
            'three' => '3',
            'four'  => '4',
            'five'  => '5',
            'six'   => '6',
            'seven' => '7',
            'eight' => '8',
            'nine'  => '9'
        ];

        // Create a regex pattern for number words (case-insensitive)
        $numberWordPattern = implode('|', array_keys($numberWordMap));

        // --- 1. Mask Natural Language Email Addresses ---
        // Regex to find patterns like "username at domain dot com"
        // It captures the parts to reconstruct the email.
        $text = preg_replace_callback(
            '/\b([A-Za-z0-9._%+-]+)\s+at\s+([A-Za-z0-9.-]+)\s+dot\s+([A-Za-z]{2,})\b/i', // 'i' for case-insensitive
            function ($matches) {
                // Reconstruct the email in a standard format
                $email = $matches[1] . '@' . $matches[2] . '.' . $matches[3];

                // Basic validation to ensure it's a valid email before masking
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    // If the reconstructed email is not valid, return the original matched string
                    return $matches[0];
                }

                $parts = explode('@', $email);
                $username = $parts[0];
                $domain = $parts[1];

                // Mask username: first character + 'X' for the rest
                $maskedUsername = substr($username, 0, 1) . str_repeat('X', strlen($username) - 1);

                // Reconstruct the masked email address
                return $maskedUsername . '@' . $domain;
            },
            $text
        );


        // --- 2. Mask Standard Email Addresses ---
        // Regex to find common email patterns.
        // \b for word boundaries, [A-Za-z0-9._%+-]+ for username, @, [A-Za-z0-9.-]+ for domain, \.[A-Za-z]{2,} for TLD.
        $text = preg_replace_callback(
            '/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}\b/',
            function ($matches) {
                $email = $matches[0];
                // Basic validation to ensure it's a valid email before masking
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return $email; // Return original if not a valid email format
                }

                $parts = explode('@', $email);
                // Ensure there are exactly two parts (username and domain)
                if (count($parts) !== 2) {
                    return $email;
                }

                $username = $parts[0];
                $domain = $parts[1];

                // Mask username: first character + 'X' for the rest
                $maskedUsername = substr($username, 0, 1) . str_repeat('X', strlen($username) - 1);

                // Reconstruct the masked email address
                return $maskedUsername . '@' . $domain;
            },
            $text
        );

        // --- 3. Mask Phone Numbers (Word-based and Mixed) ---
        // This regex looks for sequences of number words or digits, potentially separated by spaces.
        // It's designed to capture patterns like "nine eight three", "nine 8 seven", "123 four five six".
        // The callback will then extract only the numerical digits before masking.
        $text = preg_replace_callback(
            '/\b(?:' . $numberWordPattern . '|\d+)(?:\s*(?:' . $numberWordPattern . '|\d+))*\b/i',
            function ($matches) use ($numberWordMap) {
                $matchedString = $matches[0];
                $digitsOnly = '';

                // Split the matched string into individual words/numbers
                $parts = preg_split('/\s+/', $matchedString);

                foreach ($parts as $part) {
                    // Check if the part is a number word
                    $lowerPart = strtolower($part);
                    if (isset($numberWordMap[$lowerPart])) {
                        $digitsOnly .= $numberWordMap[$lowerPart];
                    } elseif (is_numeric($part)) {
                        // If it's a numeric digit string
                        $digitsOnly .= $part;
                    }
                    // Ignore other non-numeric words or symbols for phone number construction
                }

                // Only proceed with masking if we extracted a reasonable number of digits
                // A typical phone number has at least 7 digits (e.g., local number) up to 15 (international)
                if (strlen($digitsOnly) < 7 || strlen($digitsOnly) > 15) {
                    return $matchedString; // Return original if not enough digits for a phone number
                }

                // Apply the same masking logic as for standard phone numbers
                $unmaskedLength = max(0, strlen($digitsOnly) - 8);
                $unmaskedPart = substr($digitsOnly, 0, $unmaskedLength);
                $maskedPartLength = strlen($digitsOnly) - $unmaskedLength;
                $maskedPart = str_repeat('X', $maskedPartLength);

                return $unmaskedPart . $maskedPart;
            },
            $text
        );

        // --- 4. Mask Phone Numbers (Standard Digit-based) ---
        // This step remains to catch any digit-based phone numbers that might not
        // have been caught by the more specific word-based regex (e.g., due to different spacing or formats).
        // It's important to run this *after* the word-based one to prioritize word conversion.
        $text = preg_replace_callback(
            '/\b(?:\+?\d{1,4}[-.\s]*)?(?:\(\d{2,5}\)|\d{2,5})[-.\s]*\d{2,5}[-.\s]*\d{4,}\b|\b\d[\d\s\-\(\).]{7,}\d\b/',
            function ($matches) {
                $phoneNumber = $matches[0];

                // Remove all non-digit characters to get a clean number
                $digitsOnly = preg_replace('/\D/', '', $phoneNumber);

                // If no digits are found or the number is empty, return original
                if (strlen($digitsOnly) === 0) {
                    return $phoneNumber;
                }

                // Determine how many initial digits to keep unmasked
                $unmaskedLength = max(0, strlen($digitsOnly) - 8);

                // Extract the unmasked part
                $unmaskedPart = substr($digitsOnly, 0, $unmaskedLength);

                // Calculate the number of 'X's needed for the masked part
                $maskedPartLength = strlen($digitsOnly) - $unmaskedLength;
                $maskedPart = str_repeat('X', $maskedPartLength);

                // Reconstruct the masked phone number
                return $unmaskedPart . $maskedPart;
            },
            $text
        );

        return $text;
    }

    public static function packageversionstatusoption()
    {
        return [
            '1' => 'Live',
            '2' => 'Pending',
            '3' => 'Draft',
            '4' => 'Terminated',
        ];
    }

    public static function fdStayOption()
    {
        return ArrayHelper::map(MetaStayCategory::find()->where(['status' => 1])->orderBy(['sequence_for_share_safari' => SORT_ASC])->all(), 'id', 'title');
    }

    public static function liveGallery($id)
    {
        $live_gallery = PartnerGallery::find()->where(['safari_operator_id' => $id, 'status' => PartnerGallery::STATUS_ACTIVE])->andWhere(['IS NOT', 'live_images', NULL]);
        return ArrayHelper::map($live_gallery->all(), 'id', 'title');
    }
    public static function generatePdfContent($viewPath, $params = [])
    {
        // Render the partial view
        return $content = Yii::$app->view->renderFile(Yii::getAlias($viewPath), $params);

        // // Generate the PDF
        // $pdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf']);
        // $pdf->WriteHTML($content);
        // $pdfFilePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'quotation_' . $params['quotation']->id . '.pdf';
        // $pdf->Output($pdfFilePath, \Mpdf\Output\Destination::FILE);

        // return $pdfFilePath;
    }
    public static function chattype($type)
    {
        $types = [
            1 => 'Direct Chat',
            2 => 'Operator Quote Chat',
        ];

        return $types[$type] ?? '';
    }
}
