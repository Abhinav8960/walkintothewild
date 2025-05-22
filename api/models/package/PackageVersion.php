<?php

namespace api\models\package;

use api\models\master\packagefeature\MasterPackagefeature;
use api\models\master\packageinclude\MasterPackageInclude;
use api\models\master\vehicle\MasterVehicle;
use api\models\meta\MetaPackageRange;
use api\models\operator\SafariOperator;
use api\models\park\SafariPark;
use api\models\UserWishlist;
use Yii;
use common\models\User;

class PackageVersion extends \common\models\package\PackageVersion
{
    public function fields()
    {
        $fields = [
            'id',
            'package_display_name',
            'package_name',
            'version',
            'package_slug' => function () {
                return  $this->package->package_slug;
            },
            // 'is_any_live_version' => function () {
            //     return (bool) !empty($this->package->live_version) ? true : false;
            // },
            // 'is_any_pending_for_approval_version' => function () {
            //     return (bool) !empty($this->package->pending_for_approval_version) ? true : false;
            // },
            'package_status_label' => function () {
                $str = "";
                if (!empty($this->package->pending_for_approval_version)) {
                    $str = "Pending For Approval";
                } elseif (!empty($this->package->pending_for_approval_version)) {
                    $str = "Live";
                }
                return $str;
            },
            'primary_park',
            'no_of_day',
            'no_of_night',
            'no_of_night',
            'no_of_safari',
            'cost_per_person' => function () {
                return (int) ceil($this->cost_per_person);
            },
            'total_price' => function () {
                return (int) ceil($this->total_price);
            },
            'package_description',
            'image_path',
            'image_banner_path',
            'is_wishlist',
            'package_day_night_labels',
            'pick_and_drop',
            'pick_and_drop_display',
            'package_range',
            'meals_listing',
            'partner',
            'comment_count',
            'urls',
            'lunch_included' => function () {
                return (bool)$this->lunch_included;
            },
            'dinner_included' => function () {
                return (bool)$this->dinner_included;
            },
            'meal_not_included' => function () {
                return (bool)$this->meal_not_included;
            },
            'breakfast_included' => function () {
                return (bool)$this->breakfast_included;
            },
            'start_location',
            'end_location',
            'start_date',
            'end_date',
            'status'
        ];
        $fields[] = 'resource_uri';
        $fields[] = 'can_comment';
        $fields[] = 'can_reply';

        if (in_array(\Yii::$app->controller->layout, [SELF::PACKAGE_API_LAYOUT_FULL, SELF::PACKAGE_API_LAYOUT_FULL_WITH_VERSION])) {
            $fields[] = 'package_itinerary_overview';
            $fields[] = 'master_package_with_included';
            $fields[] = 'package_inclusion';
            $fields[] = 'package_exclusion';
            $fields[] = 'package_terms_condtition';
            $fields[] = 'privacy_policy';
            $fields[] = 'change_policy';
            $fields[] = 'what_you_must_carry';
            $fields[] = 'date_change_policy';
            $fields[] = 'refund_policy';
            $fields[] = 'getting_there';
            $fields[] = 'pick_and_drop';
            $fields[] = 'meals';
            $fields[] = 'meals_label';

            $fields[] = 'package_park';
            $fields[] = 'package_days';
            $fields[] = 'faqs';
            $fields[] = 'type';
            $fields[] = 'master_vehicle_id';
            $fields[] = 'package_features_name';
            $fields[] = 'safari_type';
            $fields[] = 'gst_percentage';
            $fields[] = 'package_agenda_id';
            $fields[] = 'stay_category_id';
            $fields[] = 'status';
        }
        if (in_array(\Yii::$app->controller->layout, [SELF::PACKAGE_API_LAYOUT_FULL_WITH_VERSION])) {
            $fields[] = 'package_versions';
        }
        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        // return [
        //     [['package_name'], 'required'],
        //     [['no_of_day', 'no_of_night', 'no_of_safari', 'stay_category_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status', 'popular_package'], 'integer'],
        //     [['cost_per_person'], 'number'],
        //     [['package_description', 'package_inclusion', 'package_itinerary_overview', 'package_exclusion', 'package_terms_condtition'], 'string'],
        //     [['package_name'], 'string', 'max' => 512],
        //     // [['package_slug'], 'string', 'max' => 720],
        //     [['start_location', 'end_location'], 'string', 'max' => 255],
        //     [['package_id'],'integer'],
        // ];

        return [
            [['owned_by_id', 'package_agenda_id', 'safari_type', 'start_location', 'end_location', 'start_date', 'end_date', 'package_image', 'package_banner_image', 'stay_category_id', 'type', 'gst_percentage', 'package_description', 'package_itinerary_overview', 'package_inclusion', 'package_exclusion', 'package_terms_condtition', 'privacy_policy', 'change_policy', 'what_you_must_carry', 'date_change_policy', 'refund_policy', 'getting_there', 'master_vehicle_id', 'cancellation_reason', 'popular_package', 'delete_reason_id', 'delete_reason', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['version'], 'default', 'value' => 'v1'],
            [['total_view'], 'default', 'value' => 0],
            [['total_price'], 'default', 'value' => 0.00],
            [['is_published_on_api'], 'default', 'value' => 1],
            [['owned_by_id', 'package_agenda_id', 'no_of_day', 'no_of_night', 'safari_type', 'no_of_safari', 'stay_category_id', 'type', 'gst_percentage', 'master_vehicle_id', 'breakfast_included', 'lunch_included', 'dinner_included', 'meal_not_included', 'popular_package', 'delete_reason_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_published_on_web', 'is_published_on_api', 'status', 'total_view'], 'integer'],
            [['start_date', 'end_date', 'status'], 'safe'],
            [['cost_per_person', 'total_price'], 'number'],
            [['package_description', 'package_itinerary_overview', 'package_inclusion', 'package_exclusion', 'package_terms_condtition', 'privacy_policy', 'change_policy', 'what_you_must_carry', 'date_change_policy', 'refund_policy', 'getting_there', 'cancellation_reason', 'delete_reason'], 'string'],
            [['version', 'start_location', 'end_location', 'package_image', 'package_banner_image'], 'string', 'max' => 255],
            [['version'], 'string', 'max' => 10],
            [['package_name'], 'string', 'max' => 512],
            [['package_id'], 'integer'],


        ];
    }


    public function getPackage_display_name()
    {

        $name = $this->package_name;

        if ($singlepark = $this->singlepark) {
            if ($park = $singlepark->park) {
                $title_sub = explode(" ", $park->title);
                if (isset($title_sub[0])) {
                    $name .= " - " . $title_sub[0];
                }
            }
        }

        return $name;
    }


    public function getMaster_package_with_included()
    {

        $arr = [];
        $i = 0;
        foreach ($this->packageincluded as $key => $mgi) {
            if (isset($mgi->packageInclude)) {
                $arr[$i]['id'] = $mgi->packageInclude->id;
                $arr[$i]['title'] = $mgi->packageInclude->title;
                $arr[$i]['option'] = $mgi->getIncludeoption();
                $i++;
            }
        }
        return $arr;
    }



    public function getLivePackage()
    {
        return $this->hasOne(Package::class, ['id' => 'package_id', 'live_version' => 'version']);
    }

    public function getPackage()
    {
        return $this->hasOne(Package::class, ['id' => 'package_id']);
    }

    // public function getIs_any_version_live()
    // {
    //     return $this->hasOne(Package::class, ['id' => 'package_id']);
    // }

    // public function getIs_any_version_pending_for_approve()
    // {
    //     return $this->hasOne(Package::class, ['id' => 'package_id']);
    // }


    // public function getPackage_slug()
    // {
    //     return $this->getPackage()->package_slug;
    // }




    public function getPackageincluded()
    {
        return $this->hasMany(PackageIncluded::className(), ['package_id' => 'package_id', 'version' => 'version'])->andWhere(['package_included.status' => PackageIncluded::STATUS_ACTIVE]);
    }


    public function getPackagefeatures()
    {
        return $this->hasMany(PackageFeature::className(), ['package_id' => 'package_id', 'version' => 'version'])->andWhere(['package_feature.status' => PackageFeature::STATUS_ACTIVE]);
    }

    public function getPackage_features_name()
    {
        return $this->hasMany(MasterPackagefeature::class, ['id' => 'feature_id'])->via('packagefeatures');
    }


    // public function getPackageIncludeds()
    // {
    //     return $this->hasMany(PackageIncluded::class, ['package_id' => 'package_id', 'version' => 'version']);
    // }

    public function getPackage_days()
    {
        return $this->hasMany(PackageDay::class, ['package_id' => 'package_id', 'version' => 'version']);
    }

    public function getImage_path()
    {
        $image_path = '';
        if (isset($this->package_image)) {
            $image_path = \Yii::$app->params['s3_endpoint'] . '/package/' . $this->id . '/' . $this->package_image;
        } else {

            if (isset($this->singlepark)) {
                if (isset($this->singlepark->park) && isset($this->singlepark->park->logo)) {
                    $image_path = $this->singlepark->park->logoimagepath;
                } else {
                    $image_path = '';
                }
            } else {
                $image_path = '';
            }
        }

        return $image_path;
    }


    public function getImage_banner_path()
    {
        $image_path = '';
        if (isset($this->package_banner_image)) {
            $image_path = \Yii::$app->params['s3_endpoint'] . 'storage/package/' . $this->id . '/' . $this->package_banner_image;
        } else {

            if (isset($this->singlepark)) {
                if (isset($this->singlepark->park) && isset($this->singlepark->park->logo)) {
                    $image_path = $this->singlepark->park->logoimagepath;
                } else {
                    $image_path = '';
                }
            } else {
                $image_path = '';
            }
        }

        return $image_path;
    }

    public function getComments()
    {
        return $this->hasMany(PackageComment::class, ['package_id' => 'package_id', 'version' => 'version']);
    }

    public function getComment_count()
    {
        return $this->getComments()->where(['parent_id' => null])->count();
    }


    public function getSafarioperatorUser()
    {
        return $this->partner ? $this->partner->user : null;
        // return $this->hasOne(User::className(), ['id' => 'owned_by_id']);
    }

    public function getPartner()
    {
        return $this->hasOne(SafariOperator::class, ['id' => 'owned_by_id']);
    }

    public function getMastervehicle()
    {
        return $this->hasOne(MasterVehicle::class, ['id' => 'master_vehicle_id']);
    }


    public function getPickdrop()
    {
        $package_includes = PackageIncluded::find()->where(['package_id' => $this->id, 'include_id' => 3, 'selection' => 1, 'status' => PackageIncluded::STATUS_ACTIVE])->limit(1)->one();
        return ($package_includes) ? 'Included' : 'Not Included';
    }


    /**
     * Parks List
     */


    public function getSinglepark()
    {
        return $this->hasOne(PackageSafariPark::className(), ['package_id' => 'package_id', 'version' => 'version']);
    }

    public function getPrimary_park()
    {
        return $this->singlepark ? $this->singlepark->park->title : null;
    }


    /**
     * Parks List
     */
    public function getPackagesafaripark()
    {
        return $this->hasMany(PackageSafariPark::className(), ['package_id' => 'package_id', 'version' => 'version']);
    }

    public function getPackage_park()
    {
        return $this->hasMany(SafariPark::class, ['id' => 'park_id'])->via('packagesafaripark');
    }

    public function getPackage_range()
    {
        return $this->hasOne(MetaPackageRange::class, ['id' => 'stay_category_id']);
    }

    public function getPackagegallery()
    {
        return $this->hasMany(PackageGallery::className(), ['package_id' => 'package_id', 'version' => 'version']);
    }

    public function getPackage_day_night_labels()
    {
        $options = [
            1 => '0N/1D',
            2 => '1N/2D',
            3 => '2N/3D',
            4 => '3N/4D',
            5 => '4N/5D',
            6 => '5N/6D',
            7 => '6N/7D',
            8 => '7N/8D',
            9 => '8N/9D',
            10 => '9N/10D',
            11 => '10N/11D',
            12 => '11N/12D',
            13 => '12N/13D',
            14 => '13N/14D',
            15 => '14N/15D',
        ];

        return isset($options[$this->no_of_day]) ? $options[$this->no_of_day] : "";
    }


    public function getPick_and_drop()
    {
        $pick_drop_includes = PackageIncluded::find()->where(['package_id' => $this->id, 'include_id' => 3, 'selection' => 1, 'status' => PackageIncluded::STATUS_ACTIVE])->limit(1)->one();

        // return ($pick_drop_includes) ? 'Included' : 'Not Included';
        return ($pick_drop_includes) ? true : false;
    }

    public function getPick_and_drop_display()
    {
        return $this->getPick_and_drop() == 1 ?  'Included' : 'Not Included';
    }



    public function getMeals()
    {

        $meals_text = '';
        if ($this->breakfast_included == 1 || $this->lunch_included == 1 || $this->dinner_included == 1) {
            $meals_text = 'Included';
        }



        return ($meals_text) ? $meals_text : 'Not Included';
    }

    public function getMeals_listing()
    {
        if ($this->breakfast_included == 1 || $this->lunch_included == 1 || $this->dinner_included == 1) {
            return 'Included';
        }


        return 'Not Included';
    }

    public function getMeals_label()
    {
        $mealOptions = [];


        if ($this->breakfast_included == 1) {
            $mealOptions[] = 'Breakfast';
        }
        if ($this->lunch_included == 1) {
            $mealOptions[] = 'Lunch';
        }
        if ($this->dinner_included == 1) {
            $mealOptions[] = 'Dinner';
        }
        if ($this->meal_not_included == 1) {
            $mealOptions[] = 'Not Included';
        }

        return $mealOptions ? implode(', ', $mealOptions) : 'Not Included';
    }

    public function getPackageFaqs()
    {
        return $this->hasMany(PackageFaq::className(), ['package_id' => 'package_id', 'version' => 'version'])->andWhere(['package_faq.status' => PackageFaq::STATUS_ACTIVE]);
    }

    public function getFaqs()
    {
        if ($this->getPackageFaqs()->count() > 0) {
            return $this->packageFaqs;
        }
        return   [
            [
                'question' => "Are meals included in the Package?",
                'answer' => $this->meals == 'Included' ? "Yes: Meals are included and will be provided as per the itinerary." : "No: Meals are not included; it will be charged additionally.",
            ],
            [
                'question' => "Does the Package include transport to and from the resort?",
                'answer' => $this->pick_and_drop == 'Included' ? "Yes: Transport to and from the resort is included in the Package." : "No: Transport is not included; you will need to arrange your own.",
            ],
            [
                'question' => "Are accommodation arrangements included in the Package?",
                'answer' => $this->accomodationIncludes == 'Included' ? "Yes: Accomodation is included." : "No: Accomodation is not included.",
            ],

        ];
    }


    public function getActiveUserWishlist()
    {
        return $this->hasOne(UserWishlist::className(), ['item_id' => 'package_id'])->where(['user_id' => \Yii::$app->params['active_user_id'], 'item_type_id' => 1])->andWhere(['user_wishlist.status' => 1]);
    }



    public function getIs_wishlist()
    {
        $is_whislist = $this->activeUserWishlist;
        if (!empty($is_whislist)) {
            return true;
        }
        return false;
    }

    public function getSearchpackagepark()
    {
        return $this->hasMany(PackageSafariPark::className(), ['package_id' => 'package_id']);
    }

    public function getUrls()
    {
        return [
            // 'operators' =>  Yii::$app->params['api_url'] . '/operator/' . $this->partner->slug,
            // 'parks' =>  Yii::$app->params['api_url'] . '/package/' . $this->package_slug . '/package-park',
            // 'package_days' =>  Yii::$app->params['api_url'] . '/package/' . $this->package_slug . '/package-faqs',
            // 'faqs' =>  Yii::$app->params['api_url'] . '/package/' . $this->package_slug . '/package-days',
            'comments' =>  Yii::$app->params['api_url'] . '/package/' . $this->package->package_slug . '/comment-view',
        ];
    }

    public function getResource_uri()
    {
        return Yii::$app->params['frontend_url'] . '/package/' . $this->partner->slug . '/' . $this->package->package_slug;
    }

    public function getCan_comment()
    {
        if (\Yii::$app->params['active_user_id']) {
            return true;
        }
        return false;
    }

    public function getCan_reply()
    {
        if (\Yii::$app->params['active_user_id'] == $this->owned_by_id) {
            return true;
        }
        return false;
    }

    public function attributeTypes()
    {
        return [
            'status' => self::TYPE_BOOLEAN,
        ];
    }

    public function getVersions()
    {
        return $this->hasMany(self::className(), ['package_id' => 'package_id']);
    }

    public function getPackage_versions()
    {
        $arr = [];

        foreach ($this->versions as $key => $version) {
            $arr[$key]['id'] = $version->id;
            $arr[$key]['version'] = $version->version;
            $arr[$key]['package_name'] = $version->package_name;
            $arr[$key]['package_display_name'] = $version->package_display_name;
            $arr[$key]['status_label'] = $version->statusLabel;
        }

        return $arr;
    }
}
