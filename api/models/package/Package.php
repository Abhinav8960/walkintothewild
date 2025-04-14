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
// $fields[] = 'pickanddrop';
//     $fields[] = 'mealslisting';
//     $fields[] = 'packagerange';
//     if (!in_array(\Yii::$app->controller->action->uniqueId,  ['operator/default/view'])) {
//         $fields[] = 'safarioperator';
//     }
//     $fields[] = 'imagepath';
//     $fields[] = 'imagebannerpath';
//     $fields[] = 'packagename';
//     if (!in_array(\Yii::$app->controller->action->uniqueId,  ['park/default/view'])) {
//         $fields[] = 'packagepark';
//     }

//     $fields[] = 'packagedaynightlabels';
//     $fields[] = 'isWishlist';

class Package extends \common\models\package\Package
{
    public function fields()
    {
        $fields = ['id', 'packagename', 'package_name', 'package_slug', 'primaryPark', 'no_of_day', 'no_of_night', 'no_of_night', 'no_of_safari', 'cost_per_person', 'total_price', 'package_description', 'imagepath', 'imagebannerpath', 'isWishlist', 'packagedaynightlabels', 'pickanddrop', 'packagerange', 'mealslisting', 'safarioperator', 'commentCount', 'urls', 'lunch_included', 'dinner_included', 'meal_not_included', 'breakfast_included', 'start_location', 'end_location', 'start_date', 'end_date',];
        $fields[] = 'resourceuri';
        $fields[] = 'canComment';
        $fields[] = 'canReply';

        if (in_array(\Yii::$app->controller->layout, [SELF::PACKAGE_API_LAYOUT_FULL])) {
            $fields[] = 'package_itinerary_overview';
            $fields[] = 'masterPackageWithIncluded';
            $fields[] = 'package_inclusion';
            $fields[] = 'package_exclusion';
            $fields[] = 'package_terms_condtition';
            $fields[] = 'privacy_policy';
            $fields[] = 'change_policy';
            $fields[] = 'what_you_must_carry';
            $fields[] = 'date_change_policy';
            $fields[] = 'refund_policy';
            $fields[] = 'getting_there';
            $fields[] = 'pickanddrop';
            $fields[] = 'meals';
            $fields[] = 'mealslabel';

            $fields[] = 'packagepark';
            $fields[] = 'packagedays';
            $fields[] = 'faqs';
            $fields[] = 'type';
            $fields[] = 'master_vehicle_id';
            $fields[] = 'packagefeaturesname';
            $fields[] = 'safari_type';
            $fields[] = 'gst_percentage';
            $fields[] = 'package_agenda_id';
            $fields[] = 'stay_category_id';
            $fields[] = 'status';
        }
        return $fields;
        // if (in_array(\Yii::$app->controller->action->uniqueId,  ['package/default/view'])) {
        //     $fields[] = 'packagename';
        //     $fields[] = 'masterPackageWithIncluded';
        //     $fields[] = 'safarioperator';
        //     $fields[] = 'packagepark';
        //     $fields[] = 'pickanddrop';
        //     $fields[] = 'meals';
        //     $fields[] = 'mealslisting';
        //     $fields[] = 'packagerange';
        //     $fields[] = 'imagepath';
        //     $fields[] = 'imagebannerpath';
        //     $fields[] =  'packagedays';
        //     // $fields[] = 'comments';
        //     $fields[] = 'faqs';
        //     $fields[] = 'isWishlist';
        //     $hold_fields = [
        //         'start_location',
        //         'end_location',
        //         'start_date',
        //         'end_date',
        //         'package_image',
        //         'package_banner_image',
        //         'owned_by_id',
        //         'package_name',
        //         'type',
        //         'gst_percentage',
        //         'master_vehicle_id',
        //         'breakfast_included',
        //         'lunch_included',
        //         'dinner_included',
        //         'meal_not_included',
        //         'popular_package',
        //         'delete_reason_id',
        //         'delete_reason',
        //         'total_view',
        //         'status',
        //         'created_by',
        //         'updated_by',
        //         'created_at',
        //         'created_by',
        //         'updated_at',
        //     ];
        // } else {
        //     $fields[] = 'pickanddrop';
        //     $fields[] = 'mealslisting';
        //     $fields[] = 'packagerange';
        //     if (!in_array(\Yii::$app->controller->action->uniqueId,  ['operator/default/view'])) {
        //         $fields[] = 'safarioperator';
        //     }
        //     $fields[] = 'imagepath';
        //     $fields[] = 'imagebannerpath';
        //     $fields[] = 'packagename';
        //     if (!in_array(\Yii::$app->controller->action->uniqueId,  ['park/default/view'])) {
        //         $fields[] = 'packagepark';
        //     }

        //     $fields[] = 'packagedaynightlabels';
        //     $fields[] = 'isWishlist';
        //     $hold_fields = [
        //         'package_agenda_id',
        //         'safari_type',
        //         'start_location',
        //         'end_location',
        //         'start_date',
        //         'end_date',
        //         'package_image',
        //         'package_banner_image',
        //         'stay_category_id',
        //         'cost_per_person',
        //         'type',
        //         'gst_percentage',
        //         'package_description',
        //         'package_itinerary_overview',
        //         'package_inclusion',
        //         'package_exclusion',
        //         'package_terms_condtition',
        //         'privacy_policy',
        //         'change_policy',
        //         'what_you_must_carry',
        //         'date_change_policy',
        //         'refund_policy',
        //         'getting_there',
        //         'master_vehicle_id',
        //         'breakfast_included',
        //         'lunch_included',
        //         'dinner_included',
        //         'meal_not_included',
        //         'popular_package',
        //         'delete_reason_id',
        //         'delete_reason',
        //         'owned_by_id',
        //         'package_name',
        //         'total_view',
        //         'status',
        //         'created_by',
        //         'updated_by',
        //         'created_at',
        //         'created_by',
        //         'updated_at',
        //     ];
        // }



        // return array_diff($fields, $hold_fields);
        // return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['package_name', 'package_slug'], 'required'],
            [['no_of_day', 'no_of_night', 'no_of_safari', 'stay_category_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status', 'popular_package'], 'integer'],
            [['cost_per_person'], 'number'],
            [['package_description', 'package_inclusion', 'package_itinerary_overview', 'package_exclusion', 'package_terms_condtition'], 'string'],
            [['package_name'], 'string', 'max' => 512],
            [['package_slug'], 'string', 'max' => 720],
            [['start_location', 'end_location'], 'string', 'max' => 255],
        ];
    }


    public function getPackagename()
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


    public function getMasterPackageWithIncluded()
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




    public function getPackageincluded()
    {
        return $this->hasMany(PackageIncluded::className(), ['package_id' => 'id'])->andWhere(['package_included.status' => PackageIncluded::STATUS_ACTIVE]);
    }


    public function getPackagefeatures()
    {
        return $this->hasMany(PackageFeature::className(), ['package_id' => 'id'])->andWhere(['package_feature.status' => PackageFeature::STATUS_ACTIVE]);
    }

    public function getPackagefeaturesname()
    {
        return $this->hasMany(MasterPackagefeature::class, ['id' => 'feature_id'])->via('packagefeatures');
    }


    // public function getPackageIncludeds()
    // {
    //     return $this->hasMany(PackageIncluded::class, ['package_id' => 'id']);
    // }

    public function getPackagedays()
    {
        return $this->hasMany(PackageDay::class, ['package_id' => 'id']);
    }

    public function getImagepath()
    {
        $image_path = '';
        if (isset($this->package_image)) {
            $image_path = \Yii::$app->params['frontend_url_for_api'] . 'storage/package/' . $this->id . '/' . $this->package_image;
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


    public function getImagebannerpath()
    {
        $image_path = '';
        if (isset($this->package_banner_image)) {
            $image_path = \Yii::$app->params['frontend_url_for_api'] . 'storage/package/' . $this->id . '/' . $this->package_banner_image;
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
        return $this->hasMany(PackageComment::class, ['package_id' => 'id']);
    }

    public function getCommentCount()
    {
        return $this->getComments()->where(['parent_id' => null])->count();
    }


    public function getSafarioperatorUser()
    {
        return $this->safarioperator ? $this->safarioperator->user : null;
        // return $this->hasOne(User::className(), ['id' => 'owned_by_id']);
    }

    public function getSafarioperator()
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
        return $this->hasOne(PackageSafariPark::className(), ['package_id' => 'id']);
    }

    public function getPrimaryPark()
    {
        return $this->singlepark->park->title;
    }


    /**
     * Parks List
     */
    public function getPackagesafaripark()
    {
        return $this->hasMany(PackageSafariPark::className(), ['package_id' => 'id']);
    }

    public function getPackagepark()
    {
        return $this->hasMany(SafariPark::class, ['id' => 'park_id'])->via('packagesafaripark');
    }

    public function getPackagerange()
    {
        return $this->hasOne(MetaPackageRange::class, ['id' => 'stay_category_id']);
    }

    public function getPackagegallery()
    {
        return $this->hasMany(PackageGallery::className(), ['package_id' => 'id']);
    }

    public function getPackagedaynightlabels()
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


    public function getPickanddrop()
    {
        $pick_drop_includes = PackageIncluded::find()->where(['package_id' => $this->id, 'include_id' => 3, 'selection' => 1, 'status' => PackageIncluded::STATUS_ACTIVE])->limit(1)->one();

        return ($pick_drop_includes) ? 'Included' : 'Not Included';
    }



    public function getMeals()
    {

        $meals_text = '';
        if ($this->breakfast_included == 1 || $this->lunch_included == 1 || $this->dinner_included == 1) {
            $meals_text = 'Included';
        }



        return ($meals_text) ? $meals_text : 'Not Included';
    }

    public function getMealslisting()
    {
        if ($this->breakfast_included == 1 || $this->lunch_included == 1 || $this->dinner_included == 1) {
            return 'Included';
        }


        return 'Not Included';
    }

    public function getMealslabel()
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
        return $this->hasMany(PackageFaq::className(), ['package_id' => 'id'])->andWhere(['package_faq.status' => PackageFaq::STATUS_ACTIVE]);
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
                'answer' => $this->pickanddrop == 'Included' ? "Yes: Transport to and from the resort is included in the Package." : "No: Transport is not included; you will need to arrange your own.",
            ],
            [
                'question' => "Are accommodation arrangements included in the Package?",
                'answer' => $this->accomodationIncludes == 'Included' ? "Yes: Accomodation is included." : "No: Accomodation is not included.",
            ],

        ];
    }


    public function getActiveUserWishlist()
    {
        return $this->hasOne(UserWishlist::className(), ['item_id' => 'id'])->where(['user_id' => \Yii::$app->params['active_user_id'], 'item_type_id' => 1])->andWhere(['user_wishlist.status' => 1]);
    }



    public function getIsWishlist()
    {
        $is_whislist = $this->activeUserWishlist;
        if (!empty($is_whislist)) {
            return true;
        }
        return false;
    }

    public function getSearchpackagepark()
    {
        return $this->hasMany(PackageSafariPark::className(), ['package_id' => 'id']);
    }

    public function getUrls()
    {
        return [
            // 'operators' =>  Yii::$app->params['api_url'] . '/operator/' . $this->safarioperator->slug,
            // 'parks' =>  Yii::$app->params['api_url'] . '/package/' . $this->package_slug . '/package-park',
            // 'packagedays' =>  Yii::$app->params['api_url'] . '/package/' . $this->package_slug . '/package-faqs',
            // 'faqs' =>  Yii::$app->params['api_url'] . '/package/' . $this->package_slug . '/package-days',
            'comments' =>  Yii::$app->params['api_url'] . '/package/' . $this->package_slug . '/comment-view',
        ];
    }

    public function getResourceuri()
    {
        return Yii::$app->params['frontend_url'] . '/package/' . $this->safarioperator->slug . '/' . $this->package_slug;
    }

    public function getCanComment()
    {
        if (\Yii::$app->params['active_user_id']) {
            return true;
        }
        return false;

    }

    public function getCanReply()
    {
        if(\Yii::$app->params['active_user_id'] == $this->owned_by_id)
        {
            return true;
        }
        return false;
    }
}
